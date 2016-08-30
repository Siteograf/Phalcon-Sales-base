//NOTES: Requires Jquery - version 2.2.0 was used during development but may work on earlier version
//       Add style by defining highlight class

/*Searh text highlighter*/
$highlighter = (function(){
    function highlightHtml(source, searchInput) {
        var node = $.type(source) == "object" ? source : $($.parseHTML("<div>" + source + "</div>"));
    
        if (node.children().length > 0) {
            //wrap the text contents with a span
            //this is a an alternative for using contents().data due to its lack of control to hmtl encoding
            node.contents().filter(function () { return this.nodeType === 3; }).wrap("<span></span>").end();
    
            //apply highlights to the child nodes
            node.children().each(function (index) {
                this.highlightHtml($(this), searchInput);
            });
        }
        else {
            //apply highlight to current node
            if (isUsable(node.html()))
                node.html(this.highlightText(node.html(), searchInput));
            else
                node[0].innerText = this.highlightText(node.text(), searchInput);
        }
    
        return node.html() || node[0].innerText;
    }

    function highlightText(sourceText, searchInput) {
        if (!isUsable(sourceText) || !isUsable(searchInput)) {
            return "";
        }
        
        if (sourceText != "" && searchInput != "") {
            var sourceTextLower = sourceText.toLowerCase();
            var searchInputs = searchInput.toLowerCase().replace(/\"/g, "").match(/\b\w+\b/g);
    
            //make sure our input is not null 
            if (searchInputs == null) {
                searchInputs = [];
            }
    
            //make sure our input is unique
            searchInputs = distinctArray(searchInputs);
            //make sure we have the longest item process first
            searchInputs.sort(function (a, b) {
                return a.length < b.length;
            });
    
            var finalIndices = [];
            var indicesFound = [];
            var iStart = 0;
            var iLast = 0;
            for (var i = 0; i < sourceTextLower.length; i++) {
                iStart = i;
    
                //apply excemptions
                var moveToNextCharIndex = iFindNextIndexIfCurrentCharIsStartOf("&nbsp;", sourceTextLower, iStart);
                if (iStart != moveToNextCharIndex) {
                    i = moveToNextCharIndex;
                    continue;
                }
    
                //loop to all search text                 
                for (var j = 0; j < searchInputs.length; j++) {
                    var searchText = searchInputs[j];
                    var x = i;
                    var y = 0;
                    while (y < searchText.length && searchText.charAt(y) == sourceTextLower.charAt(x)) {
                        y++;
                        x++;
                    }
    
                    if (y == searchText.length) {
                        //we found a match
                        iLast = i + searchText.length;
                        indicesFound.push({ start: iStart, last: iLast });
                        continue;
                    }
                }
            }
    
            //merge adjacent indices
            for (var z = 0; z < indicesFound.length; z++) {
                iStart = indicesFound[z].start;
                iLast = indicesFound[z].last;
    
                var nextIndex = z + 1;
                var nextStart = 0;
                var nextLast = 0;
                if (nextIndex < indicesFound.length) {
                    nextStart = indicesFound[nextIndex].start;
                    nextLast = indicesFound[nextIndex].last;
    
                    while (iLast >= nextStart) {
                        iLast = iLast <= nextLast ? nextLast : iLast;
                        z++;
                        nextIndex++
                        if (nextIndex < indicesFound.length) {
                            nextStart = indicesFound[nextIndex].start;
                            nextLast = indicesFound[nextIndex].last;
                        }
                        else {
                            break;
                        }
                    }
                }
                finalIndices.push({ start: iStart, last: iLast });
            }
    
            //inject the span based on the indeces found
            for (var z = finalIndices.length - 1; z >= 0; z--) {
                iStart = finalIndices[z].start;
                iLast = finalIndices[z].last;
    
                var sPrepend = sourceText.substring(0, iStart);
                var sAppend = sourceText.substring(iLast, sourceText.length);
    
                sourceText = sPrepend + "<b class='highlight'>" + sourceText.substring(iStart, iLast) + "</b>" + sAppend;
            }
        }
    
        return sourceText;
    }

    function iFindNextIndexIfCurrentCharIsStartOf(exemptText, sourceText, currentCharIndex) {
        if (typeof (exemptText) != "undefined" && exemptText != null && exemptText != "") {
            var findExemptText = sourceText.substring(currentCharIndex, currentCharIndex + exemptText.length);
            if (exemptText == findExemptText) {
                currentCharIndex = currentCharIndex + exemptText.length - 1;
                bResult = true;
            }
        }
        return currentCharIndex;
    }
/*End Searh text highlighter*/

/*common functions*/
    function isUsable(target) {
        return typeof (target) != "undefined" && target != null;
    }
    
    function createSort(sortColumns) {
        var result = [];
    
        if (isUsable(sortColumns) && $.isArray(sortColumns)) {
            for (var i = 0; i < sortColumns.length; i++) {
                var column = sortColumns[i];
                result.push({ field: column.field, direction: column.sort != null ? column.sort.direction : "asc" });
            }
        }
    
        return result;
    }
    
    function distinctArray(array) {
        var unique = [];
    
        if (typeof (array) == 'undefined' || array == null) {
            return [];
        }
    
        array.forEach(function (value) {
            if (unique.indexOf(value) === -1) {
                unique.push(value);
            }
        });
    
        return unique;
    }
/*End common functions*/
    
    return { 
        highlightHtml: highlightHtml, 
        highlightText: highlightText
    };
})();