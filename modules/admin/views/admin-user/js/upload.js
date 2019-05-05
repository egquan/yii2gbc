layui.use(['upload','layer'], function(){
  var upload = layui.upload,layer = parent.layer === undefined ? layui.layer : parent.layer;

    upload.render({
        elem: '#test3',
        url: "<?=yii\helpers\Url::to(['/admin/admin-user/upload'])?>",
        field: 'UploadForm',
        data: {
            UploadForm: function () {
                return $('.upload_input').val();
            }
        },
        done: function(res){
            if(res.code==200){
                //修改上传成功后需要修改的地方
                $("#signup-head_pic").val(res.data);
                $("#user-head_pic").val(res.data);
                $(".userinfo_head_pic").attr('src', res.data.src);
                $(".upload_input").attr('value', res.data.src);
                //修改父窗口数据
                parent.$('.header_user_head_pic').attr('src',res.data);
                layer.msg("上传成功");
            }else{
                layer.msg("上传失败");
            }
        },
        error: function(){
            layer.msg("请求异常");
        }
    });
});