{!! $result->appends(Request::all())->render() !!}
@foreach($result as $user)
    <div class="list-group">
        <a href="{{ route('users.profile', $user) }}"  class="list-group-item">
            <div class="row">
                <div class="col-md-1">
                    {!! $user->profile->ImgAvatar(90,90,'') !!}
                </div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="list-group-item-heading">{{ $user->nickname }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="list-group-item-text">
                                {{ config('options.types')[$user->type] }}
                            </p>
                            <p class="list-group-item-text">
                                Posts: {{ count($user->posts) }}
                            </p>
                            <p class="list-group-item-text">
                                Hilos: {{ count($user->threads) }}
                            </p>
                        </div>
                        <div class="col-md-2">
                            <p class="list-group-item-text">
                                {{ $user->profile->website }}
                            </p>
                            <p class="list-group-item-text">
                                {{ $user->profile->twitter }}
                            </p>
                            <p class="list-group-item-text">
                                Edad: {{ $user->profile->age }}
                            </p>
                            <p class="list-group-item-text">
                                País: {{ $user->profile->country }}
                            </p>
                        </div>
                        <div class="col-md-8">
                            <p class="list-group-item-text">
                                <strong>Acerca de {{ $user->nickname }}:</strong>
                            </p>
                            <p class="list-group-item-text">
                                @if ($user->profile->bio != '')
                                    {!! nl2br(e($user->profile->bio)) !!}
                                @else
                                    <i>Este usuario aún no ha redactado su bio. Que pendejete jeje.</i>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
{!! $result->appends(Request::all())->render() !!}
