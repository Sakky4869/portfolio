

let sections = null;


window.onload = function () {
    window.scrollTo(0, 0);
    createSkillCharts(skills_json_object);

    let productionMoreInfoButtonArray = document.getElementsByClassName('production-more-info');
    // console.log(productionMoreInfoButtonArray);
    for (let i = 0; i < productionMoreInfoButtonArray.length; i++) {
        productionMoreInfoButtonArray[i].addEventListener('click', function (e) {
            // console.log(productionDatas[i]['detail']);
            document.getElementById('label-more-info').innerHTML = productionDatas[i]['title'];
            document.getElementById('moreinfo-content').innerHTML = marked(productionDatas[i]['detail']);
            // $('#label-more-info').val(productionDatas[i]['title']);
            // $('#moreinfo-content').val(productionDatas[i]['detail']);
        });
    }
    // console.log(Object.keys(skills_json_object));
    let skillKindArray = Object.keys(skills_json_object);

    let skillMoreInfoButtonArray = document.getElementsByClassName('skill-more-info');
    for (let i = 0; i < skillMoreInfoButtonArray.length; i++) {
        skillMoreInfoButtonArray[i].addEventListener('click', function (e) {

            // let skillKind = skillDatas[i]['skill_kind'];
            let skillKind = skillKindArray[i];
            // console.log(skillKind);
            document.getElementById('label-more-info').innerHTML = skillKind;
            let markdownString = '';
            for (let j = 0; j < skillDatas.length; j++) {
                if (skillDatas[j]['skill_kind'] == skillKind) {
                    markdownString += skillDatas[j]['skill_details'] + '\n\n';
                }
            }
            // document.getElementById('moreinfo-content').innerHTML = marked(skillDatas[i]['skill_details']);
            document.getElementById('moreinfo-content').innerHTML = marked(markdownString);
        });
    }
}

document.addEventListener('DOMContentLoaded', event => {
    setAllSectionsDisplay('none');
    countGoogleDriveLoadEvent();
});


function createSkillCharts(skill_datas) {
    // console.log(skill_datas);
    let chartCanvasList = document.getElementsByClassName('skill-chart');
    for (let i = 0; i < chartCanvasList.length; i++) {
        let chartCanvas = chartCanvasList[i];
        let ctx = chartCanvas.getContext('2d');
        let kind = chartCanvas.dataset.kind;
        // console.log(kind);
        let evaluateData = skill_datas[kind];
        // console.log(evaluateData);
        let keys = Object.keys(evaluateData);
        let values = Object.values(evaluateData);
        let chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: keys,
                datasets: [{
                    label: 'レベル',
                    data: values,
                    borderColor: 'rgba(255, 255, 255, 255)',
                    // backgroundColor: 'rgba(255, 0, 0, 5)'
                    backgroundColor: '#7c7c7c',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maxBarThickness: 50,
                title: {
                    display: true,
                    text: 'test'
                }
            }
        });

        // チャートのタイトルを設定
        let chartTitle = chartCanvas.parentElement.children[0];
        chartTitle.innerText = kind;

        // let labels = [];
        // let datas = [];
        // for (let j = 0; j < keys.length; j++) {
        //     let key = keys[j];

        // }

    }
    // console.log('chart canvas count : ' +chartCanvasList.length);
    // console.log(skill_datas);
}


/**
 * すべてのsectionの表示非表示を切り替える
 * @param {string} state 表示するかしないか
 */
function setAllSectionsDisplay(state) {
    if (sections == null) {
        sections = document.getElementsByClassName('section');
    } else {
        // console.log(sections.length);
    }
    for (let i = 0; i < sections.length; i++) {
        let section = sections[i];
        section.style.display = state;
        // console.log('section ' + section.id + ' set ' + state);
    }
}


/**
 * ロードが完了したiframeの数をカウントする
 */
function countGoogleDriveLoadEvent() {
    // 全てのGoogle Drive iframeを取得
    let iframes = document.getElementsByTagName('iframe');
    let loadedCount = 0;
    setProgressBarValue(0, iframes.length);
    for (let i = 0; i < iframes.length; i++) {
        let iframe = iframes[i];
        // iframeのloadイベントを追加
        iframe.onload = () => {
            loadedCount += 1;
            // console.log('ロード完了：' + (i + 1) + ' / ' + iframes.length);
            if (loadedCount == iframes.length) {
                console.log('全iframeロード完了');
            }
            setProgressBarValue(loadedCount, iframes.length);
        };

    }
};

/**
 * ロードが完了したiframeの数に応じてロード画面の状態を変える
 * @param {int} count ロードが完了したiframeの数
 * @param {int} max iframeの総数
 */
function setProgressBarValue(count, max) {
    // プログレスバーを取得
    let progressBar = document.getElementById('load-progress-bar');

    // 現在のカウントから進捗を計算
    let progress = 100 / max * count;

    // プログレスバーに値を表示
    progressBar.style.width = progress + '%';
    progressBar.setAttribute('aria-valuenow', progress);
    progressBar.innerText = progress + '%';

    // プログレスが100%になったら，ロード画面を非表示にする
    if (progress == 100) {
        document.getElementById('load-panel').style.display = 'none';
        setAllSectionsDisplay('flex');

    }
}

