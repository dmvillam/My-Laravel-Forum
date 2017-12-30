<div ng-app="entryRepliesApp" ng-controller="entryRepliesController">
    @if ( ! Auth::guest())
        <a href="" ng-click="toggleForm(0)">Responder</a>
        <form ng-submit="submitComment()" ng-show="showForm[0]" id="0">
            {!! Form::hidden('_token', csrf_token(), ['ng-model' => 'EntryReplyData._token', 'class' => '_token']) !!}
            {!! Form::hidden('user_id', Auth::user()->id, ['ng-model' => 'EntryReplyData.user_id', 'class' => 'user_id']) !!}
            {!! Form::hidden('blog_id', $entry->blog->id, ['ng-model' => 'EntryReplyData.blog_id', 'class' => 'blog_id']) !!}
            {!! Form::hidden('entry_id', $entry->id, ['ng-model' => 'EntryReplyData.entry_id', 'class' => 'entry_id']) !!}
            {!! Form::hidden('reply_id', 0, ['ng-model' => 'EntryReplyData.reply_id', 'class' => 'reply_id']) !!}
            <table style="">
                <tr>
                    <td style="padding: 0 5px;">
                        {!! Auth::user()->profile->ImgAvatar(45,45) !!}
                    </td>
                    <td style="padding: 0 5px; width: 85%;">
                        <div class="form-horizontal-sm">
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => 'Ingresar comentario', 'style' => 'width: 100%; height: 35px;', 'ng-model' => 'EntryReplyData.content', 'required' => 'required']) !!}
                        </div>
                    </td>
                    <td style="padding: 0 5px;">
                        <button type="submit" class="btn btn-info">Comentar</button>
                    </td>
                </tr>
            </table>
        </form>
    @endif

    <h3>Comentarios <i class="fa fa-spinner fa-pulse fa-fw" ng-show="loading"></i></h3>

    <div ng-repeat="comment in comments" style="margin: 16px 0;">
        <div style="float: left; margin: 0 16px;">
            <img src="<%comment.avatar_url%>" class="img-circle" style="max-width: 60px; max-height: 60px;" ng-if="!comment.deleted">
            <div style="width: 60px; height: 60px; border-radius: 30px; background: darkgray;" ng-if="comment.deleted">
                <span style="color: white; font-size: 3.2em; font-weight: bold; padding-left: 14px;">X</span>
            </div>
        </div>
        <div style="overflow: hidden">
            <p style="font-size: 0.8em;" ng-if="!comment.deleted">
                <a href="{{ url('/users') }}/<%comment.user_id%>">
                    <strong><%comment.nickname%></strong>
                </a>
                <i style="color: darkgrey;"> • <%comment.created_at%></i>
            </p>
            <p ng-if="!comment.deleted"><%comment.content%></p>
            <p ng-if="comment.deleted">
                <a href="{{ url('/users') }}/<%comment.user_id%>">
                    <strong><%comment.nickname%></strong>
                </a>
                <i style="color: darkgrey;">Este comentario ha sido eliminado.</i>
            </p>
            <p ng-if="!comment.deleted">
                <a href="" ng-click="toggleForm(comment.id)" ng-if="auth_user_id != 0">Responder</a>
                <a href="" ng-click="" ng-if="comment.user_id == auth_user_id">Editar</a>
                <a href="" ng-click="deleteComment(comment.id)" ng-if="comment.user_id == auth_user_id || auth_user_id == entry_user_id">Borrar</a>
            </p>
            <p ng-if="comment.deleted">
                <a href="" ng-click="deleteComment(comment.id)" ng-if="auth_user_id == entry_user_id">Restaurar</a>
            </p>
            @if ( ! Auth::guest())
                <form ng-submit="submitComment()" ng-show="showForm[comment.id]" id="<%comment.id%>">
                    {!! Form::hidden('_token', csrf_token(), ['ng-model' => 'EntryReplyData._token', 'class' => '_token']) !!}
                    {!! Form::hidden('user_id', Auth::user()->id, ['ng-model' => 'EntryReplyData.user_id', 'class' => 'user_id']) !!}
                    {!! Form::hidden('blog_id', $entry->blog->id, ['ng-model' => 'EntryReplyData.blog_id', 'class' => 'blog_id']) !!}
                    {!! Form::hidden('entry_id', $entry->id, ['ng-model' => 'EntryReplyData.entry_id', 'class' => 'entry_id']) !!}
                    <input class="reply_id" type="hidden" name="reply_id" value="<%comment.id%>" ng-model="EntryReplyData.reply_id" />
                    <table style="">
                        <tr>
                            <td style="padding: 0 5px;">
                                {!! Auth::user()->profile->ImgAvatar(45,45) !!}
                            </td>
                            <td style="padding: 0 5px; width: 85%;">
                                <div class="form-horizontal-sm">
                                    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => 'Ingresar comentario', 'style' => 'width: 100%; height: 35px;', 'ng-model' => 'EntryReplyData.content', 'required' => 'required']) !!}
                                </div>
                            </td>
                            <td style="padding: 0 5px;">
                                <button type="submit" class="btn btn-info">Comentar</button>
                            </td>
                        </tr>
                    </table>
                </form>
            @endif
            <div ng-repeat="reply in comment.replies" style="margin: 16px 0;">
                <div style="float: left; margin: 0 16px;">
                    <img src="<%reply.avatar_url%>" class="img-circle" style="max-width: 60px; max-height: 60px;" ng-if="!reply.deleted">
                    <div style="width: 60px; height: 60px; border-radius: 30px; background: darkgray;" ng-if="reply.deleted">
                        <span style="color: white; font-size: 3.2em; font-weight: bold; padding-left: 14px;">X</span>
                    </div>
                </div>
                <div style="overflow: hidden">
                    <p style="font-size: 0.8em;" ng-if="!reply.deleted">
                        <a href="{{ url('/users') }}/<%reply.user_id%>">
                            <strong><%reply.nickname%></strong>
                        </a>
                        <span style="color: darkgrey;">
                            <i> • <%reply.created_at%></i>
                            • <i class="glyphicon glyphicon-share-alt"></i> <%comment.nickname%>
                        </span>
                    </p>
                    <p ng-if="!reply.deleted"><%reply.content%></p>
                    <p ng-if="reply.deleted">
                        <a href="{{ url('/users') }}/<%reply.user_id%>">
                            <strong><%reply.nickname%></strong>
                        </a>
                        <i style="color: darkgrey;">Este comentario ha sido eliminado.</i>
                    </p>
                    <p ng-if="!reply.deleted">
                        <a href="" ng-click="toggleForm(reply.id)" ng-if="auth_user_id != 0">Responder</a>
                        <a href="" ng-click="" ng-if="reply.user_id == auth_user_id">Editar</a>
                        <a href="" ng-click="deleteComment(reply.id)" ng-if="reply.user_id == auth_user_id || auth_user_id == entry_user_id">Borrar</a>
                    </p>
                    <p ng-if="reply.deleted">
                        <a href="" ng-click="deleteComment(reply.id)" ng-if="auth_user_id == entry_user_id">Restaurar</a>
                    </p>
                    @if ( ! Auth::guest())
                        <form ng-submit="submitComment()" ng-show="showForm[reply.id]" id="<%reply.id%>">
                            {!! Form::hidden('_token', csrf_token(), ['ng-model' => 'EntryReplyData._token', 'class' => '_token']) !!}
                            {!! Form::hidden('user_id', Auth::user()->id, ['ng-model' => 'EntryReplyData.user_id', 'class' => 'user_id']) !!}
                            {!! Form::hidden('blog_id', $entry->blog->id, ['ng-model' => 'EntryReplyData.blog_id', 'class' => 'blog_id']) !!}
                            {!! Form::hidden('entry_id', $entry->id, ['ng-model' => 'EntryReplyData.entry_id', 'class' => 'entry_id']) !!}
                            <input class="reply_id" type="hidden" name="reply_id" value="<%reply.id%>" ng-model="EntryReplyData.reply_id" />
                            <table style="">
                                <tr>
                                    <td style="padding: 0 5px;">
                                        {!! Auth::user()->profile->ImgAvatar(45,45) !!}
                                    </td>
                                    <td style="padding: 0 5px; width: 85%;">
                                        <div class="form-horizontal-sm">
                                            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => 'Ingresar comentario', 'style' => 'width: 100%; height: 35px;', 'ng-model' => 'EntryReplyData.content', 'required' => 'required']) !!}
                                        </div>
                                    </td>
                                    <td style="padding: 0 5px;">
                                        <button type="submit" class="btn btn-info">Comentar</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    @endif
                    <div ng-repeat="subreply in reply.replies" style="margin: 16px 0;">
                        <div style="float: left; margin: 0 16px;">
                            <img src="<%subreply.avatar_url%>" class="img-circle" style="max-width: 60px; max-height: 60px;" ng-if="!subreply.deleted">
                            <div style="width: 60px; height: 60px; border-radius: 30px; background: darkgray;" ng-if="subreply.deleted">
                                <span style="color: white; font-size: 3.2em; font-weight: bold; padding-left: 14px;">X</span>
                            </div>
                        </div>
                        <div style="overflow: hidden">
                            <p style="font-size: 0.8em;" ng-if="!subreply.deleted">
                                <a href="{{ url('/users') }}/<%subreply.user_id%>">
                                    <strong><%subreply.nickname%></strong>
                                </a>
                        <span style="color: darkgrey;">
                            <i> • <%subreply.created_at%></i>
                            • <i class="glyphicon glyphicon-share-alt"></i> <%reply.nickname%>
                        </span>
                            </p>
                            <p ng-if="!subreply.deleted"><%subreply.content%></p>
                            <p ng-if="subreply.deleted">
                                <a href="{{ url('/users') }}/<%subreply.user_id%>">
                                    <strong><%subreply.nickname%></strong>
                                </a>
                                <i style="color: darkgrey;">Este comentario ha sido eliminado.</i>
                            </p>
                            <p ng-if="!subreply.deleted">
                                <a href="" ng-click="" ng-if="subreply.user_id == auth_user_id">Editar</a>
                                <a href="" ng-click="deleteComment(subreply.id)" ng-if="subreply.user_id == auth_user_id || auth_user_id == entry_user_id">Borrar</a>
                            </p>
                            <p ng-if="subreply.deleted">
                                <a href="" ng-click="deleteComment(subreply.id)" ng-if="auth_user_id == entry_user_id">Restaurar</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

