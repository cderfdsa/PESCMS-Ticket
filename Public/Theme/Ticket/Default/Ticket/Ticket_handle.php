<div class="am-padding-xs am-padding-top-0">
    <?php require THEME . '/Ticket/Common/Ticket_view_package.php'; ?>

    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <h3 class="am-margin-0">处理工单</h3>
        </div>
        <?php if ($ticket_status < 3 && $ticket_close == '0' && ($user_id == $this->session()->get('ticket')['user_id'] || empty($user_id) ) ): ?>
            <ul class="am-list am-list-static am-text-sm">
                <li>
                    <div class="am-g am-g-collapse">
                        <div class="am-u-lg-8">
                            <form action="<?= $label->url('Ticket-Ticket-reply'); ?>" class="am-form ajax-submit" method="POST" data-am-validator>
                                <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>
                                <input type="hidden" name="back_url" value="<?= $_GET['back_url']; ?>"/>
                                <?php if ($ticket_status == '0'): ?>
                                    <div class="am-form-group">
                                        <label class="am-form-label am-margin-bottom-0">受理工单 : </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="0" checked>
                                            假装没看见
                                        </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="1">
                                            开始受理
                                        </label>
                                    </div>
                                <?php elseif (in_array($ticket_status, ['1', '2'])): ?>
                                    <div class="am-form-group">
                                        <label class="am-form-label am-margin-bottom-0">是否需要转派 : </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="2" checked="checked">
                                            否
                                        </label>
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="3">
                                            是
                                        </label>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="form-radio-label am-radio-inline">
                                            <input type="radio" name="assign" value="4">
                                            设置工单完成
                                        </label>
                                    </div>
                                    <div class="am-form-group am-hide assign-user">
                                        <label for="">转派给</label>
                                        <select name="uid">
                                            <option value="">转派给谁呢？</option>
                                            <?php foreach ($user as $value): ?>
                                                <option value="<?= $value['user_id']; ?>"><?= $value['user_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="am-form-group pt-reply-content">
                                        <label for="">回复内容</label>
                                        <textarea name="content" rows="5"></textarea>
                                    </div>
                                <?php endif; ?>
                                <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs"
                                        data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">
                                    提交
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div>

</div>

<script>
    function assign(val) {
        if (val == '3') {
            $(".assign-user").removeClass("am-hide");
            $(".pt-reply-content").addClass("am-hide");
        }else if(val == '4'){
            if(confirm('确定要设置工单为完成吗?') == false){
                $("input[name=assign]").removeAttr("checked");
                $("input[name=assign]").eq(0).prop("checked", "checked")
            }else{
                $("form").submit();
            }
        } else {
            $(".assign-user").addClass("am-hide");
            $(".pt-reply-content").removeClass("am-hide");
        }
    }
    $(function () {
        assign($("input[name=assign]:checked").val());
        $("input[name=assign]").change(function () {
            assign($(this).val());
        })
    })
</script>
