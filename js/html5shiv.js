(function(a,b){function k(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;c.innerHTML="x<style>"+b+"</style>";return d.insertBefore(c.lastChild,d.firstChild)}function l(){var a=r.elements;return typeof a=="string"?a.split(" "):a}function m(a){var b=i[a[g]];if(!b){b={};h++;a[g]=h;i[h]=b}return b}function n(a,c,f){if(!c){c=b}if(j){return c.createElement(a)}if(!f){f=m(c)}var g;if(f.cache[a]){g=f.cache[a].cloneNode()}else if(e.test(a)){g=(f.cache[a]=f.createElem(a)).cloneNode()}else{g=f.createElem(a)}return g.canHaveChildren&&!d.test(a)?f.frag.appendChild(g):g}function o(a,c){if(!a){a=b}if(j){return a.createDocumentFragment()}c=c||m(a);var d=c.frag.cloneNode(),e=0,f=l(),g=f.length;for(;e<g;e++){d.createElement(f[e])}return d}function p(a,b){if(!b.cache){b.cache={};b.createElem=a.createElement;b.createFrag=a.createDocumentFragment;b.frag=b.createFrag()}a.createElement=function(c){if(!r.shivMethods){return b.createElem(c)}return n(c,a,b)};a.createDocumentFragment=Function("h,f","return function(){"+"var n=f.cloneNode(),c=n.createElement;"+"h.shivMethods&&("+l().join().replace(/\w+/g,function(a){b.createElem(a);b.frag.createElement(a);return'c("'+a+'")'})+");return n}")(r,b.frag)}function q(a){if(!a){a=b}var c=m(a);if(r.shivCSS&&!f&&!c.hasCSS){c.hasCSS=!!k(a,"article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}"+"mark{background:#FF0;color:#000}")}if(!j){p(a,c)}return a}var c=a.html5||{};var d=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i;var e=/^<|^(?:a|b|button|code|div|fieldset|form|h1|h2|h3|h4|h5|h6|i|iframe|img|input|label|li|link|ol|option|p|param|q|script|select|span|strong|style|table|tbody|td|textarea|tfoot|th|thead|tr|ul)$/i;var f;var g="_html5shiv";var h=0;var i={};var j;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>";f="hidden"in a;j=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){f=true;j=true}})();var r={elements:c.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:c.shivCSS!==false,supportsUnknownElements:j,shivMethods:c.shivMethods!==false,type:"default",shivDocument:q,createElement:n,createDocumentFragment:o};a.html5=r;q(b)})(this,document)