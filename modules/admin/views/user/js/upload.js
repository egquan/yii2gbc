layui.use(['upload', 'layer'], function () {
    var upload = layui.upload, layer = parent.layer === undefined ? layui.layer : parent.layer;

    upload.render({
        elem: '#test3',
        url: "<?=yii\helpers\Url::to(['/admin/admin-user/upload'])?>",
        field: 'Upload',
        done: function (res) {
            if (res.code === '0') {
                //修改上传成功后需要修改的地方
                $(".userinfo_head_pic").attr('src', res.data.src);
                $(".upload_input").attr('value', res.data.src);
                //修改父窗口数据
                parent.$('.header_user_head_pic').attr('src', res.data.src);
                layer.msg("上传成功");
            } else {
                layer.msg("上传失败");
            }
        },
        error: function () {
            layer.msg("请求异常");
        }
    });
});