
/**
 * 謝罪イメージの表示モード
 * １：お辞儀画像表示
 * ０：スマイル画像表示
 */
let commingSoonMode = 1;

window.onload = function () {

    window.scrollTo(0, 0);
    // setInterval(switchCommingSoonImage, 1000);

};

// const switchCommingSoonImage = function () {

//     // お辞儀画像取得
//     let sorryImages = document.getElementsByClassName('comming-soon');

//     // 表示切替
//     for (let i = 0; i < sorryImages.length; i++) {
//         let sorryImage = sorryImages[i];
//         sorryImage.style.display = (commingSoonMode == 1) ? 'inline' : 'none';
//     }

//     // スマイル画像取得
//     let smileImages = document.getElementsByClassName('comming-soon-smile');

//     // 表示切替
//     for (let i = 0; i < smileImages.length; i++) {
//         let smileImage = smileImages[i];
//         smileImage.style.display = (commingSoonMode == 1) ? 'none' : 'inline';
//     }

//     commingSoonMode = 1 - commingSoonMode;

// };
