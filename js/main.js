
/**
 * 謝罪イメージの表示モード
 * １：お辞儀画像表示
 * ０：スマイル画像表示
 */
let commingSoonMode = 1;

let sections = null;

// Google Driveのiframeコンテンツのロード検知について
// PHPでGoogle Driveコンテンツを出力したあとに，jsでiframe要素の数を取得し，
// 全iframe要素に対して，読み込み完了イベントであるloadイベントにカウント関数を設定
// カウント関数の処理内容は，ロードが完了したiframe要素の数をカウントする
// すべてロードできたらWebページを表示する

window.onload = function () {
    // countGoogleDriveLoadEvent();
    // setAllSectionsDisplay('none');
    window.scrollTo(0, 0);
    // setInterval(switchCommingSoonImage, 1000);

};

document.addEventListener('DOMContentLoaded', event => {
    setAllSectionsDisplay('none');
    countGoogleDriveLoadEvent();
});

function setAllSectionsDisplay(state){
    if(sections == null){
        sections = document.getElementsByClassName('section');
    }else{
        console.log(sections.length);
    }
    for (let i = 0; i < sections.length; i++) {
        let section = sections[i];
        section.style.display = state;
        console.log('section ' + section.id + ' set ' + state);
    }
}

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


function countGoogleDriveLoadEvent(){
    // 全てのGoogle Drive iframeを取得
    let iframes = document.getElementsByTagName('iframe');
    let loadedCount = 0;
    setProgressBarValue(0, iframes.length);
    for (let i = 0; i < iframes.length; i++) {
        let iframe = iframes[i];
        // iframeのloadイベントを追加
        iframe.onload = () => {
            loadedCount += 1;
            console.log('ロード完了：' + (i + 1) + ' / ' + iframes.length);
            if(loadedCount == iframes.length){
                console.log('全iframeロード完了');
            }
            setProgressBarValue(loadedCount, iframes.length);
        };
        
    }
};

function setProgressBarValue(count, max){
    // プログレスバーを取得
    let progressBar = document.getElementById('load-progress-bar');

    // 現在のカウントから進捗を計算
    let progress = 100 / max * count;

    // プログレスバーに値を表示
    progressBar.style.width = progress + '%';
    progressBar.setAttribute('aria-valuenow', progress);
    progressBar.innerText = progress + '%';
    
    // プログレスが100%になったら，ロード画面を非表示にする
    if(progress == 100){
        document.getElementById('load-panel').style.display = 'none';
        setAllSectionsDisplay('flex');
        
    }
}

