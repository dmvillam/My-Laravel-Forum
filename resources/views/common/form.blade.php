<div class="row comment-form" style="background: #d5d5d5; padding: 10px; margin-bottom: 40px;">
    <div style="margin: 5px; float: left;">{!! Auth::user()->profile->ImgAvatar(40,40) !!}</div>
    <div style="background: #e8e8e8; padding: 5px; margin-left: 58px;">
        <div id="commentBoxShortened" role="textbox" style="background: white; cursor: text; padding: 5px; display: block; color: gray; padding: 10px;"><i class="glyphicon glyphicon-comment"></i> Comentar...</div>
        @include('common.form-partials.expanded-box')
    </div>
</div>