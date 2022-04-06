/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("https://storage.googleapis.com/workbox-cdn/releases/6.1.5/workbox-sw.js");

workbox.skipWaiting();
workbox.clientsClaim();

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "css/style.css",
    "revision": "07168654d3e0648f93f59a9bc537457a"
  },
  {
    "url": "css/lightbox.min.css",
    "revision": "767938d77eef356b1ba76c3897384948"
  },
  {
    "url": "js/jquery.min.js",
    "revision": "b354cc9d56a1da6b0c77604d1b153850"
  },
  {
    "url": "css/search.css",
    "revision": "c1f2a50d1f6903ebeac7432fa1d70f5a"
  },
   {
    "url": "css/comments.css",
    "revision": "1999d64221003e829e10e1a21e36b399"
  },
  {
    "url": "js/lazyload.js",
    "revision": "377c7f9061416449faef372ff1fba9ed"
  },
  {
    "url": "js/main.js",
    "revision": "70b27067d04d0c6008ef57238ec6c9db"
  },
  {
    "url": "js/lightbox.min.js",
    "revision": "86ae6c62f555df51346b0be4bc2d0267"
  },
  {
    "url": "lib/font-awesome/css/font-awesome.css",
    "revision": "38021bc5f4c004f5afbee38855ba260f"
  },
  {
    "url": "lib/font-awesome/css/font-awesome.min.css",
    "revision": "48ab1883875b3c7f06592dd04eb2c297"
  },
  {
    "url": "lib/font-awesome/fonts/fontawesome-webfont.woff",
    "revision": "c8ddf1e5e5bf3682bc7bebf30f394148"
  },
  {
    "url": "lib/font-awesome/fonts/fontawesome-webfont.woff2",
    "revision": "e6cf7c6ec7c2d6f670ae9d762604cb0b"
  },
  {
    "url": "lib/highlight.min.js",
    "revision": "bdbf53ccebb5d5daac05c2b6db7a69dc"
  },
    {
    "url": "lib/OwO/OwO.min.js",
    "revision": "b14ecca1a89c41307ebbc5a2ff70cb50"
  },
    {
    "url": "lib/OwO/OwO.min.css",
    "revision": "fa21a60e7f352aadb07cdf75d04e2c4e"
  },

  {
    "url": "lib/meslo-LG/fonts/MesloLGS-Regular.woff",
    "revision": "c26c11f108b98536a374afb1337e156c"
  },
  {
    "url": "lib/meslo-LG/styles.css",
    "revision": "711087aaff7624e62edd074044ec1dd9"
  },
  {
    "url": "lib/typed.js",
    "revision": "c4d749bea1bf41b435328c6171c37c6d"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.suppressWarnings();
workbox.precaching.precacheAndRoute(self.__precacheManifest, {});

workbox.routing.registerRoute(/.*\.js/, workbox.strategies.networkFirst(), 'GET');
workbox.routing.registerRoute(/.*\.css/, workbox.strategies.staleWhileRevalidate({ plugins: [{ cacheableResponse: { statuses: [ 0, 200 ] } }] }), 'GET');
workbox.routing.registerRoute(/.*\.(?:png|jpg|jpeg|svg|gif|webp)/, workbox.strategies.cacheFirst({ plugins: [{ expiration: { maxEntries: 50 } }] }), 'GET');
workbox.routing.registerRoute(/.*\.html/, workbox.strategies.networkFirst(), 'GET');
onmessage = (event) => {
  importScripts('lib/highlight.min.js');
  const result = self.hljs.highlightAuto(event.data);
  postMessage(result.value);
};