
// DOMの構築が終わったら実行される
$(document).ready(function () {

    // -------------------------------------------
    // -------- ここから要素系変数の初期化 --------
    // -------------------------------------------

    // 制作物のタイトルを選択するselect
    let productionTitleSelect = $('#production-title-select');

    // 制作物のタイトルの入力するinput．新規の制作物情報の登録に利用
    let productionTitleText = $('#production-title-text');
    
    productionTitleText.css('display', 'none');

    // 制作物の概要を入力するtextarea
    let productionDescriptionTextarea = $('#production-description-text');

    // 制作物の動画のURLを入力するinput
    let productionMovieText = $('#production-movie-text');

    // 制作物の詳細情報のプレビュー入力テキスト
    let productionDetailsText = $('#production-details-text');

    // 制作物の詳細情報のプレビュー用div
    let productionDetailsPreviewDiv = $('#production-details-preview-div');

    // スキル名を選択するselect
    let skillNameSelect = $('#skill-name-select');
    
    // スキルの言語名を入力するinput
    let skillNameText = $('#skill-name-text');

    // 最初は非表示に設定
    skillNameText.css('display', 'none');

    // スキルのレベルを選択するselect
    let skillLevelSelect = $('#skill-level-select');

    // スキルの種類を選択するselect
    let skillKindSelect = $('#skill-kind-select');

    // スキルの種類名を入力するinput
    let skillKindText = $('#skill-kind-text');

    // 最初は非表示に設定
    skillKindText.css('display', 'none');

    // スキルの詳細情報のプレビューdiv
    let skillDetailsPreviewDiv = $('#skill-details-preview-div');

    // スキルの詳細情報を入力するtextarea
    let skillDetailsText = $('#skill-details-text');

    // -------------------------------------------
    // -------- ここまで要素系変数の初期化 --------
    // -------------------------------------------

    // ----------------------------------
    // -------- ここから処理関係 --------
    // ----------------------------------

    // 制作物のタイトル情報のみ抜き出して配列に入れる
    productionTitleArray = [];
    for(let i = 0; i < productionData.length; i++){
        productionTitleArray.push(productionData[i]['title']);
    }

    // 制作物のタイトルのselectの選択肢を入力
    // productionTitleArray = productionTitleData.split(',');
    
    productionTitleArray.push('新規');

    // console.log(productionTitleArray);
    for(let i = 0; i < productionTitleArray.length; i++){
        let productionTitle = productionTitleArray[i];
        productionTitleSelect.append('<option value="' + productionTitle + '">' + productionTitle + '</option>');
    }

    // 制作物で新規が選択されたときの挙動を設定
    productionTitleSelect.change(function(e){
        
        let value = $(this).val();
        // console.log(value);

        if(value == '新規'){
            productionTitleText.css('display', 'inline');
        }
        // 新規以外の場合，既存の情報を更新するので，すでに登録されているデータを表示する
        else{
            for(let i = 0; i < productionData.length; i++){
                if(productionData[i]['title'] == value){
                    productionDescriptionTextarea.val(productionData[i]['description']);
                    productionMovieText.val(productionData[i]['movie']);
                    productionDetailsText.val(productionData[i]['detail']);
                }
            }
            productionTitleText.css('display', 'none');
        }
    });
    
    
    
    // 制作物の詳細情報が入力されたときの挙動を設定
    productionDetailsText.change(function(){
        let value = $(this).val();
        // console.log('textarea change : ' + value);

        // マークダウンをHTMLに変換してプレビューに表示
        productionDetailsPreviewDiv.html(marked(value));

    });


    // スキルの言語データのみを抽出して配列にセット
    let languageArray = [];
    for(let i = 0; i < skillData.length; i++){
        languageArray.push(skillData[i]['skill_name']);
    }


    // スキルレベルの言語の選択肢を設定
    // let languageArray = languageData.split(',');
    languageArray.push('新規');

    for (let i = 0; i < languageArray.length; i++) {
        let language = languageArray[i];
        skillNameSelect.append('<option value="' + language + '">' + language + '</option>');
    }
    

    // スキルの言語でその他が選択されたときの挙動を設定
    skillNameSelect.change(function(e){

        let value = $(this).val();

        if(value == '新規'){
            skillNameText.css('display', 'inline');
        }else{

            for(let i = 0; i < skillData.length; i++){
                if(skillData[i]['skill_name'] == value){
                    skillLevelSelect.val(skillData[i]['skill_level']);
                    skillKindSelect.val(skillData[i]['skill_kind']);
                    skillDetailsText.val(skillData[i]['skill_details']);
                    skillDetailsPreviewDiv.html(marked(skillData[i]['skill_details']));
                    // console.log(skillData[i]['skill_kind']);
                }

            }

            skillNameText.css('display', 'none');
        }
    });

    // スキルの種類情報のみを抽出してセット
    let kindArray = [];
    for(let i = 0; i < skillData.length; i++){
        if(kindArray.indexOf(skillData[i]['skill_kind']) == -1){
            kindArray.push(skillData[i]['skill_kind']);
        }
    }
    kindArray.push('新規');

    // スキルの種類の選択肢を設定
    // let kindArray = kindData.split(',');

    for (let i = 0; i < kindArray.length; i++) {

        let kind = kindArray[i];
        skillKindSelect.append('<option value="' + kind + '">' + kind + '</option>')
    }

    // スキルの種類で新規が選択されたときの挙動を設定
    skillKindSelect.change(function(e){
        let value = $(this).val();

        if(value == '新規'){
            skillKindText.css('display', 'inline');
        }else{
            skillKindText.css('display', 'none');
        }
    });

    
    // スキルの詳細情報が入力されたときの挙動を設定
    skillDetailsText.change(function(){
        let value = $(this).val();
        // console.log('textarea change : ' + value);

        // マークダウンをHTMLに変換してプレビューに表示
        skillDetailsPreviewDiv.html(marked(value));

    });

    document.productionForm.reset();

});


