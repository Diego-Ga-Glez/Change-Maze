!function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.Dungeon=e():t.Dungeon=e()}("undefined"!=typeof self?self:this,function(){return function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(r,o,function(e){return t[e]}.bind(null,o));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=17)}([function(t,e){t.exports=function(){throw new Error("define cannot be used indirect")}},function(t,e){(function(e){t.exports=e}).call(this,{})},function(t,e){t.exports=function(t){return t.webpackPolyfill||(t.deprecate=function(){},t.paths=[],t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),t.webpackPolyfill=1),t}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});e.default={EMPTY:0,WALL:1,FLOOR:2,DOOR:3}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){return function(t,e){if(Array.isArray(t))return t;if(Symbol.iterator in Object(t))return function(t,e){var n=[],r=!0,o=!1,i=void 0;try{for(var a,u=t[Symbol.iterator]();!(r=(a=u.next()).done)&&(n.push(a.value),!e||n.length!==e);r=!0);}catch(t){o=!0,i=t}finally{try{!r&&u.return&&u.return()}finally{if(o)throw i}}return n}(t,e);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}();e.debugRoomGrid=function(t){var e=t.roomGrid.map(function(t){return t.map(function(t){return(""+t.length).padStart(2)})});console.log(e.map(function(t){return t.join(" ")}).join("\n"))},e.debugHtmlMap=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=e=Object.assign({},{empty:" ",emptyAttributes:{class:"dungeon__empty"},wall:"#",wallAttributes:{class:"dungeon__wall"},floor:"_",floorAttributes:{class:"dungeon__wall"},door:".",doorAttributes:{class:"dungeon__door"},containerAttributes:{class:"dungeon"}},e),r=t.getMappedTiles({empty:"<td "+i(n.emptyAttributes)+">"+n.empty+"</td>",floor:"<td "+i(n.floorAttributes)+">"+n.floor+"</td>",door:"<td "+i(n.doorAttributes)+">"+n.door+"</td>",wall:"<td "+i(n.wallAttributes)+">"+n.wall+"</td>"}).map(function(t){return"<tr>"+t.join("")+"</tr>"}).join(""),o="<pre "+i(n.containerAttributes)+"><table><tbody>"+r+"</tbody></table></pre>";return document.createRange().createContextualFragment(o)},e.debugMap=function(t){var e,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};n=Object.assign({},{empty:" ",emptyColor:"rgb(0, 0, 0)",wall:"#",wallColor:"rgb(255, 0, 0)",floor:"_",floorColor:"rgb(210, 210, 210)",door:".",doorColor:"rgb(0, 0, 255)",fontSize:"15px"},n);var r="",i=[];r+="Dungeon: the console window should be big enough to see all of the guide on the next line:\n",r+="%c|"+"=".repeat(2*t.width-2)+"|\n\n",i.push("font-size: "+n.fontSize);for(var a=0;a<t.height;a+=1){for(var u=0;u<t.width;u+=1){var h=t.tiles[a][u];h===o.default.EMPTY?(r+="%c"+n.empty,i.push("color: "+n.emptyColor+"; font-size: "+n.fontSize)):h===o.default.WALL?(r+="%c"+n.wall,i.push("color: "+n.wallColor+"; font-size: "+n.fontSize)):h===o.default.FLOOR?(r+="%c"+n.floor,i.push("color: "+n.floorColor+"; font-size: "+n.fontSize)):h===o.default.DOOR&&(r+="%c"+n.door,i.push("color: "+n.doorColor+"; font-size: "+n.fontSize)),r+=" "}r+="\n"}(e=console).log.apply(e,[r].concat(i))};var o=function(t){return t&&t.__esModule?t:{default:t}}(n(3));var i=function(t){return Object.entries(t).map(function(t){var e=r(t,2);return e[0]+'="'+e[1]+'"'}).join(" ")}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){function t(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}return function(e,n,r){return n&&t(e.prototype,n),r&&t(e,r),e}}(),o=function(t){return t&&t.__esModule?t:{default:t}}(n(3));var i=function(){function t(e,n){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.width=e,this.height=n,this.setPosition(0,0),this.doors=[],this.tiles=[];for(var r=0;r<this.height;r++){for(var i=[],a=0;a<this.width;a++)0==r||r==this.height-1||0==a||a==this.width-1?i.push(o.default.WALL):i.push(o.default.FLOOR);this.tiles.push(i)}}return r(t,[{key:"setPosition",value:function(t,e){this.x=t,this.y=e,this.left=t,this.right=t+(this.width-1),this.top=e,this.bottom=e+(this.height-1),this.centerX=t+Math.floor(this.width/2),this.centerY=e+Math.floor(this.height/2)}},{key:"getDoorLocations",value:function(){for(var t=[],e=0;e<this.height;e++)for(var n=0;n<this.width;n++)this.tiles[e][n]==o.default.DOOR&&t.push({x:n,y:e});return t}},{key:"overlaps",value:function(t){return!(this.right<t.left)&&(!(this.left>t.right)&&(!(this.bottom<t.top)&&!(this.top>t.bottom)))}},{key:"isConnectedTo",value:function(t){for(var e=this.getDoorLocations(),n=0;n<e.length;n++){var r=e[n];if(r.x+=this.x,r.y+=this.y,r.x-=t.x,r.y-=t.y,!(r.x<0||r.x>t.width-1||r.y<0||r.y>t.height-1)&&t.tiles[r.y][r.x]==o.default.DOOR)return!0}return!1}}]),t}();e.default=i},function(t,e){},function(t,e,n){var r;!function(o,i){var a,u=this,h=256,f=6,s="random",l=i.pow(h,f),c=i.pow(2,52),d=2*c,g=h-1;function v(t,e,n){var r=[],v=y(function t(e,n){var r,o=[],i=typeof e;if(n&&"object"==i)for(r in e)try{o.push(t(e[r],n-1))}catch(t){}return o.length?o:"string"==i?e:e+"\0"}((e=1==e?{entropy:!0}:e||{}).entropy?[t,x(o)]:null==t?function(){try{var t;return a&&(t=a.randomBytes)?t=t(h):(t=new Uint8Array(h),(u.crypto||u.msCrypto).getRandomValues(t)),x(t)}catch(t){var e=u.navigator,n=e&&e.plugins;return[+new Date,u,n,u.screen,x(o)]}}():t,3),r),p=new function(t){var e,n=t.length,r=this,o=0,i=r.i=r.j=0,a=r.S=[];n||(t=[n++]);for(;o<h;)a[o]=o++;for(o=0;o<h;o++)a[o]=a[i=g&i+t[o%n]+(e=a[o])],a[i]=e;(r.g=function(t){for(var e,n=0,o=r.i,i=r.j,a=r.S;t--;)e=a[o=g&o+1],n=n*h+a[g&(a[o]=a[i=g&i+e])+(a[i]=e)];return r.i=o,r.j=i,n})(h)}(r),w=function(){for(var t=p.g(f),e=l,n=0;t<c;)t=(t+n)*h,e*=h,n=p.g(1);for(;t>=d;)t/=2,e/=2,n>>>=1;return(t+n)/e};return w.int32=function(){return 0|p.g(4)},w.quick=function(){return p.g(4)/4294967296},w.double=w,y(x(p.S),o),(e.pass||n||function(t,e,n,r){return r&&(r.S&&m(r,p),t.state=function(){return m(p,{})}),n?(i[s]=t,e):t})(w,v,"global"in e?e.global:this==i,e.state)}function m(t,e){return e.i=t.i,e.j=t.j,e.S=t.S.slice(),e}function y(t,e){for(var n,r=t+"",o=0;o<r.length;)e[g&o]=g&(n^=19*e[g&o])+r.charCodeAt(o++);return x(e)}function x(t){return String.fromCharCode.apply(0,t)}if(i["seed"+s]=v,y(i.random(),o),"object"==typeof t&&t.exports){t.exports=v;try{a=n(6)}catch(t){}}else void 0===(r=function(){return v}.call(e,n,e,t))||(t.exports=r)}([],Math)},function(t,e,n){(function(t){var r;!function(t,o,i){function a(t,e){return e.a=t.a,e.b=t.b,e.c=t.c,e.d=t.d,e}function u(t,e){var n=new function(t){var e=this,n="";e.next=function(){var t=e.b,n=e.c,r=e.d,o=e.a;return t=t<<25^t>>>7^n,n=n-r|0,r=r<<24^r>>>8^o,o=o-t|0,e.b=t=t<<20^t>>>12^n,e.c=n=n-r|0,e.d=r<<16^n>>>16^o,e.a=o-t|0},e.a=0,e.b=0,e.c=-1640531527,e.d=1367130551,t===Math.floor(t)?(e.a=t/4294967296|0,e.b=0|t):n+=t;for(var r=0;r<n.length+20;r++)e.b^=0|n.charCodeAt(r),e.next()}(t),r=e&&e.state,o=function(){return(n.next()>>>0)/4294967296};return o.double=function(){do{var t=((n.next()>>>11)+(n.next()>>>0)/4294967296)/(1<<21)}while(0===t);return t},o.int32=n.next,o.quick=o,r&&("object"==typeof r&&a(r,n),o.state=function(){return a(n,{})}),o}o&&o.exports?o.exports=u:n(0)&&n(1)?void 0===(r=function(){return u}.call(e,n,e,o))||(o.exports=r):this.tychei=u}(0,"object"==typeof t&&t,n(0))}).call(this,n(2)(t))},function(t,e,n){(function(t){var r;!function(t,o,i){function a(t,e){return e.i=t.i,e.w=t.w,e.X=t.X.slice(),e}function u(t,e){null==t&&(t=+new Date);var n=new function(t){var e=this;e.next=function(){var t,n,r=e.w,o=e.X,i=e.i;return e.w=r=r+1640531527|0,n=o[i+34&127],t=o[i=i+1&127],n^=n<<13,t^=t<<17,n^=n>>>15,t^=t>>>12,n=o[i]=n^t,e.i=i,n+(r^r>>>16)|0},function(t,e){var n,r,o,i,a,u=[],h=128;for(e===(0|e)?(r=e,e=null):(e+="\0",r=0,h=Math.max(h,e.length)),o=0,i=-32;i<h;++i)e&&(r^=e.charCodeAt((i+32)%e.length)),0===i&&(a=r),r^=r<<10,r^=r>>>15,r^=r<<4,r^=r>>>13,i>=0&&(a=a+1640531527|0,o=0==(n=u[127&i]^=r+a)?o+1:0);for(o>=128&&(u[127&(e&&e.length||0)]=-1),o=127,i=512;i>0;--i)r=u[o+34&127],n=u[o=o+1&127],r^=r<<13,n^=n<<17,r^=r>>>15,n^=n>>>12,u[o]=r^n;t.w=a,t.X=u,t.i=o}(e,t)}(t),r=e&&e.state,o=function(){return(n.next()>>>0)/4294967296};return o.double=function(){do{var t=((n.next()>>>11)+(n.next()>>>0)/4294967296)/(1<<21)}while(0===t);return t},o.int32=n.next,o.quick=o,r&&(r.X&&a(r,n),o.state=function(){return a(n,{})}),o}o&&o.exports?o.exports=u:n(0)&&n(1)?void 0===(r=function(){return u}.call(e,n,e,o))||(o.exports=r):this.xor4096=u}(0,"object"==typeof t&&t,n(0))}).call(this,n(2)(t))},function(t,e,n){(function(t){var r;!function(t,o,i){function a(t,e){return e.x=t.x.slice(),e.i=t.i,e}function u(t,e){null==t&&(t=+new Date);var n=new function(t){var e=this;e.next=function(){var t,n,r=e.x,o=e.i;return t=r[o],n=(t^=t>>>7)^t<<24,n^=(t=r[o+1&7])^t>>>10,n^=(t=r[o+3&7])^t>>>3,n^=(t=r[o+4&7])^t<<7,t=r[o+7&7],n^=(t^=t<<13)^t<<9,r[o]=n,e.i=o+1&7,n},function(t,e){var n,r=[];if(e===(0|e))r[0]=e;else for(e=""+e,n=0;n<e.length;++n)r[7&n]=r[7&n]<<15^e.charCodeAt(n)+r[n+1&7]<<13;for(;r.length<8;)r.push(0);for(n=0;n<8&&0===r[n];++n);for(8==n?r[7]=-1:r[n],t.x=r,t.i=0,n=256;n>0;--n)t.next()}(e,t)}(t),r=e&&e.state,o=function(){return(n.next()>>>0)/4294967296};return o.double=function(){do{var t=((n.next()>>>11)+(n.next()>>>0)/4294967296)/(1<<21)}while(0===t);return t},o.int32=n.next,o.quick=o,r&&(r.x&&a(r,n),o.state=function(){return a(n,{})}),o}o&&o.exports?o.exports=u:n(0)&&n(1)?void 0===(r=function(){return u}.call(e,n,e,o))||(o.exports=r):this.xorshift7=u}(0,"object"==typeof t&&t,n(0))}).call(this,n(2)(t))},function(t,e,n){(function(t){var r;!function(t,o,i){function a(t,e){return e.x=t.x,e.y=t.y,e.z=t.z,e.w=t.w,e.v=t.v,e.d=t.d,e}function u(t,e){var n=new function(t){var e=this,n="";e.next=function(){var t=e.x^e.x>>>2;return e.x=e.y,e.y=e.z,e.z=e.w,e.w=e.v,(e.d=e.d+362437|0)+(e.v=e.v^e.v<<4^t^t<<1)|0},e.x=0,e.y=0,e.z=0,e.w=0,e.v=0,t===(0|t)?e.x=t:n+=t;for(var r=0;r<n.length+64;r++)e.x^=0|n.charCodeAt(r),r==n.length&&(e.d=e.x<<10^e.x>>>4),e.next()}(t),r=e&&e.state,o=function(){return(n.next()>>>0)/4294967296};return o.double=function(){do{var t=((n.next()>>>11)+(n.next()>>>0)/4294967296)/(1<<21)}while(0===t);return t},o.int32=n.next,o.quick=o,r&&("object"==typeof r&&a(r,n),o.state=function(){return a(n,{})}),o}o&&o.exports?o.exports=u:n(0)&&n(1)?void 0===(r=function(){return u}.call(e,n,e,o))||(o.exports=r):this.xorwow=u}(0,"object"==typeof t&&t,n(0))}).call(this,n(2)(t))},function(t,e,n){(function(t){var r;!function(t,o,i){function a(t,e){return e.x=t.x,e.y=t.y,e.z=t.z,e.w=t.w,e}function u(t,e){var n=new function(t){var e=this,n="";e.x=0,e.y=0,e.z=0,e.w=0,e.next=function(){var t=e.x^e.x<<11;return e.x=e.y,e.y=e.z,e.z=e.w,e.w^=e.w>>>19^t^t>>>8},t===(0|t)?e.x=t:n+=t;for(var r=0;r<n.length+64;r++)e.x^=0|n.charCodeAt(r),e.next()}(t),r=e&&e.state,o=function(){return(n.next()>>>0)/4294967296};return o.double=function(){do{var t=((n.next()>>>11)+(n.next()>>>0)/4294967296)/(1<<21)}while(0===t);return t},o.int32=n.next,o.quick=o,r&&("object"==typeof r&&a(r,n),o.state=function(){return a(n,{})}),o}o&&o.exports?o.exports=u:n(0)&&n(1)?void 0===(r=function(){return u}.call(e,n,e,o))||(o.exports=r):this.xor128=u}(0,"object"==typeof t&&t,n(0))}).call(this,n(2)(t))},function(t,e,n){(function(t){var r;!function(t,o,i){function a(t,e){return e.c=t.c,e.s0=t.s0,e.s1=t.s1,e.s2=t.s2,e}function u(t,e){var n=new function(t){var e=this,n=function(){var t=4022871197;return function(e){e=e.toString();for(var n=0;n<e.length;n++){var r=.02519603282416938*(t+=e.charCodeAt(n));r-=t=r>>>0,t=(r*=t)>>>0,t+=4294967296*(r-=t)}return 2.3283064365386963e-10*(t>>>0)}}();e.next=function(){var t=2091639*e.s0+2.3283064365386963e-10*e.c;return e.s0=e.s1,e.s1=e.s2,e.s2=t-(e.c=0|t)},e.c=1,e.s0=n(" "),e.s1=n(" "),e.s2=n(" "),e.s0-=n(t),e.s0<0&&(e.s0+=1),e.s1-=n(t),e.s1<0&&(e.s1+=1),e.s2-=n(t),e.s2<0&&(e.s2+=1),n=null}(t),r=e&&e.state,o=n.next;return o.int32=function(){return 4294967296*n.next()|0},o.double=function(){return o()+1.1102230246251565e-16*(2097152*o()|0)},o.quick=o,r&&("object"==typeof r&&a(r,n),o.state=function(){return a(n,{})}),o}o&&o.exports?o.exports=u:n(0)&&n(1)?void 0===(r=function(){return u}.call(e,n,e,o))||(o.exports=r):this.alea=u}(0,"object"==typeof t&&t,n(0))}).call(this,n(2)(t))},function(t,e,n){var r=n(13),o=n(12),i=n(11),a=n(10),u=n(9),h=n(8),f=n(7);f.alea=r,f.xor128=o,f.xorwow=i,f.xorshift7=a,f.xor4096=u,f.tychei=h,t.exports=f},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){function t(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}return function(e,n,r){return n&&t(e.prototype,n),r&&t(e,r),e}}(),o=function(t){return t&&t.__esModule?t:{default:t}}(n(14));var i=function(){function t(e){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.rng=(0,o.default)(e)}return r(t,[{key:"randomInteger",value:function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},r=n.onlyOdd,o=void 0!==r&&r,i=n.onlyEven,a=void 0!==i&&i;return o?this.randomOddInteger(t,e):a?this.randomEvenInteger(t,e):Math.floor(this.rng()*(e-t+1)+t)}},{key:"randomEvenInteger",value:function(t,e){t%2!=0&&t<e&&t++,e%2!=0&&e>t&&e--;var n=(e-t)/2;return 2*Math.floor(this.rng()*(n+1))+t}},{key:"randomOddInteger",value:function(t,e){t%2==0&&t++,e%2==0&&e--;var n=(e-t)/2;return 2*Math.floor(this.rng()*(n+1))+t}},{key:"randomPick",value:function(t){return t[this.randomInteger(0,t.length-1)]}}]),t}();e.default=i},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(){return function(t,e){if(Array.isArray(t))return t;if(Symbol.iterator in Object(t))return function(t,e){var n=[],r=!0,o=!1,i=void 0;try{for(var a,u=t[Symbol.iterator]();!(r=(a=u.next()).done)&&(n.push(a.value),!e||n.length!==e);r=!0);}catch(t){o=!0,i=t}finally{try{!r&&u.return&&u.return()}finally{if(o)throw i}}return n}(t,e);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),o=function(){function t(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}return function(e,n,r){return n&&t(e.prototype,n),r&&t(e,r),e}}(),i=f(n(15)),a=f(n(5)),u=f(n(3)),h=n(4);function f(t){return t&&t.__esModule?t:{default:t}}var s={width:50,height:50,randomSeed:void 0,doorPadding:1,rooms:{width:{min:5,max:15,onlyOdd:!1,onlyEven:!1},height:{min:5,max:15,onlyOdd:!1,onlyEven:!1},maxArea:150,maxRooms:50}},l=function(){function t(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t);var n=e.rooms||{};n.width=Object.assign({},s.rooms.width,n.width),n.height=Object.assign({},s.rooms.height,n.height),n.maxArea=n.maxArea||s.rooms.maxArea,n.maxRooms=n.maxRooms||s.rooms.maxRooms,n.width.min<3&&(n.width.min=3),n.height.min<3&&(n.height.min=3),n.width.max<n.width.min&&(n.width.max=n.width.min),n.height.max<n.height.min&&(n.height.max=n.height.min);var r=n.width.min*n.height.min;n.maxArea<r&&(n.maxArea=r),this.doorPadding=e.doorPadding||s.doorPadding,this.width=e.width||s.width,this.height=e.height||s.height,this.roomConfig=n,this.rooms=[],this.r=new i.default(e.randomSeed),this.roomGrid=[],this.generate(),this.tiles=this.getTiles()}return o(t,[{key:"drawToConsole",value:function(t){(0,h.debugMap)(this,t)}},{key:"drawToHtml",value:function(t){return(0,h.debugHtmlMap)(this,t)}},{key:"generate",value:function(){this.rooms=[],this.roomGrid=[];for(var t=0;t<this.height;t++){this.roomGrid.push([]);for(var e=0;e<this.width;e++)this.roomGrid[t].push([])}var n=this.createRandomRoom();n.setPosition(Math.floor(this.width/2)-Math.floor(n.width/2),Math.floor(this.height/2)-Math.floor(n.height/2)),this.addRoom(n);for(var r=5*this.roomConfig.maxRooms;this.rooms.length<this.roomConfig.maxRooms&&r>0;)this.generateRoom(),r-=1}},{key:"getRoomAt",value:function(t,e){return t<0||e<0||t>=this.width||e>=this.height?null:this.roomGrid[e][t][0]}},{key:"getMappedTiles",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return t=Object.assign({},{empty:0,wall:1,floor:2,door:3},t),this.tiles.map(function(e){return e.map(function(e){return e===u.default.EMPTY?t.empty:e===u.default.WALL?t.wall:e===u.default.FLOOR?t.floor:e===u.default.DOOR?t.door:void 0})})}},{key:"addRoom",value:function(t){if(!this.canFitRoom(t))return!1;this.rooms.push(t);for(var e=t.top;e<=t.bottom;e++)for(var n=t.left;n<=t.right;n++)this.roomGrid[e][n].push(t);return!0}},{key:"canFitRoom",value:function(t){if(t.x<0||t.x+t.width>this.width-1)return!1;if(t.y<0||t.y+t.height>this.height-1)return!1;for(var e=0;e<this.rooms.length;e++)if(t.overlaps(this.rooms[e]))return!1;return!0}},{key:"createRandomRoom",value:function(){var t=0,e=0,n=0,r=this.roomConfig;do{n=(t=this.r.randomInteger(r.width.min,r.width.max,{onlyEven:r.width.onlyEven,onlyOdd:r.width.onlyOdd}))*(e=this.r.randomInteger(r.height.min,r.height.max,{onlyEven:r.height.onlyEven,onlyOdd:r.height.onlyOdd}))}while(n>r.maxArea);return new a.default(t,e)}},{key:"generateRoom",value:function(){for(var t=this.createRandomRoom(),e=150;e>0;){var n=this.findRoomAttachment(t);if(t.setPosition(n.x,n.y),this.addRoom(t)){var o=this.findNewDoorLocation(t,n.target),i=r(o,2),a=i[0],u=i[1];this.addDoor(a),this.addDoor(u);break}e-=1}}},{key:"getTiles",value:function(){for(var t=Array(this.height),e=0;e<this.height;e++){t[e]=Array(this.width);for(var n=0;n<this.width;n++)t[e][n]=u.default.EMPTY}for(var r=0;r<this.rooms.length;r++)for(var o=this.rooms[r],i=0;i<o.height;i++)for(var a=0;a<o.width;a++)t[i+o.y][a+o.x]=o.tiles[i][a];return t}},{key:"getPotentiallyTouchingRooms",value:function(t){for(var e=[],n=function(n,r,o){for(var i=o[r][n],a=0;a<i.length;a++)if(i[a]!=t&&e.indexOf(i[a])<0){var u=n-i[a].x,h=r-i[a].y;(u>0&&u<i[a].width-1||h>0&&h<i[a].height-1)&&e.push(i[a])}},r=t.x+1;r<t.x+t.width-1;r++)n(r,t.y,this.roomGrid),n(r,t.y+t.height-1,this.roomGrid);for(var o=t.y+1;o<t.y+t.height-1;o++)n(t.x,o,this.roomGrid),n(t.x+t.width-1,o,this.roomGrid);return e}},{key:"findNewDoorLocation",value:function(t,e){var n={x:-1,y:-1},r={x:-1,y:-1};return t.y===e.y-t.height?(n.x=r.x=this.r.randomInteger(Math.floor(Math.max(e.left,t.left)+this.doorPadding),Math.floor(Math.min(e.right,t.right)-this.doorPadding)),n.y=t.y+t.height-1,r.y=e.y):t.x==e.x-t.width?(n.x=t.x+t.width-1,r.x=e.x,n.y=r.y=this.r.randomInteger(Math.floor(Math.max(e.top,t.top)+this.doorPadding),Math.floor(Math.min(e.bottom,t.bottom)-this.doorPadding))):t.x==e.x+e.width?(n.x=t.x,r.x=e.x+e.width-1,n.y=r.y=this.r.randomInteger(Math.floor(Math.max(e.top,t.top)+this.doorPadding),Math.floor(Math.min(e.bottom,t.bottom)-this.doorPadding))):t.y==e.y+e.height&&(n.x=r.x=this.r.randomInteger(Math.floor(Math.max(e.left,t.left)+this.doorPadding),Math.floor(Math.min(e.right,t.right)-this.doorPadding)),n.y=t.y,r.y=e.y+e.height-1),[n,r]}},{key:"findRoomAttachment",value:function(t){var e=this.r.randomPick(this.rooms),n=0,r=0,o=2*this.doorPadding;switch(this.r.randomInteger(0,3)){case 0:n=this.r.randomInteger(e.left-(t.width-1)+o,e.right-o),r=e.top-t.height;break;case 1:n=e.left-t.width,r=this.r.randomInteger(e.top-(t.height-1)+o,e.bottom-o);break;case 2:n=e.right+1,r=this.r.randomInteger(e.top-(t.height-1)+o,e.bottom-o);break;case 3:n=this.r.randomInteger(e.left-(t.width-1)+o,e.right-o),r=e.bottom+1}return{x:n,y:r,target:e}}},{key:"addDoor",value:function(t){for(var e=this.roomGrid[t.y][t.x],n=0;n<e.length;n++){var r=e[n],o=t.x-r.x,i=t.y-r.y;r.tiles[i][o]=u.default.DOOR}}}]),t}();e.default=l},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=function(t){return t&&t.__esModule?t:{default:t}}(n(16));e.default=r.default}]).default});
//# sourceMappingURL=dungeon.min.js.map