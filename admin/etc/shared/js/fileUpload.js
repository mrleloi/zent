$(function () {
  
  // 画像が登録されていないエリアは非表示とする
  $(".uploadImgArea").each(function(){
    var obj = $(this);
    
    var imgObj = null;
    if( $(this).find("img").length > 0 ){
      imgObj = $(this).find("img");
    }else if( $(this).find("video").length > 0 ){
      imgObj = $(this).find("video");
    }
    
    
    if(imgObj.attr("src") == ""){
      obj.hide();
    }else{
      obj.show();
    }
    
  });
  
  // 画像ファイルのアップロード
  $("input[type='file'].typeImg").change(function () {
    
    var key = $(this).data("key");
    
    if (this.files.length > 0) {
      // 選択されたファイル情報を取得
      var file = this.files[0];
      
      // readerのresultプロパティに、データURLとしてエンコードされたファイルデータを格納
      var reader = new FileReader();
      reader.readAsDataURL(file);

      var str = (this.id).replace(/[^0-9]/g, '');
      reader.onload = function () {
        $(".uploadImgArea[data-key='" + key + "']").fadeIn(300);
        $(".uploadImgArea[data-key='" + key + "'] img").attr('src', reader.result);
        
        //$('input[type="hidden"]#upfile_' + str).val("");
      }
    }
  });
  
  // 動画ファイルのアップロード
  $("input[type='file'].typeMovie").change(function () {
    
    var key = $(this).data("key");
    
    if (this.files.length > 0) {
      // 選択されたファイル情報を取得
      var file = this.files[0];
      
      // readerのresultプロパティに、データURLとしてエンコードされたファイルデータを格納
      var reader = new FileReader();
      reader.readAsDataURL(file);

      var str = (this.id).replace(/[^0-9]/g, '');
      reader.onload = function () {
        $(".uploadImgArea[data-key='" + key + "']").fadeIn(300);
        $(".uploadImgArea[data-key='" + key + "'] video").attr('src', reader.result);
        
        //$('input[type="hidden"]#upfile_' + str).val("");
      }
    }
  });
  
  
});
