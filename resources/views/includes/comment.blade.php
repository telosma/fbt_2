<div class="item-comment" id="item-comment-{{ $comment->id }}">
    <div class="media">
        <div class="media-left">
            <a href="#">
                <img src="{{ $comment->user->avatar_link }}" class="circle small">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $comment->user->name }}</h4>
            <div class="item-comment-content p20" id="box-comment-content-{{ $comment->id }}">
                <span>{{ $comment->content }}</span>
                @if (Auth::check())
                    @if (Auth::user()->id == $comment->user->id)
                        <div class="dropdown dropup"  aria-expanded="false">
                            <i class="fa sm fa-pencil" class="dropdown-toggle" data-toggle="dropdown" aria-hidden="true">
                            </i>
                            <ul class="dropdown-menu" data-comment-id="{{ $comment->id }}">
                                <button class="dropdown-item btn-edit-comment"
                                    data-label-update="{{ trans('user.action.update') }}"
                                    data-label-cancel="{{ trans('user.action.cancel') }}"
                                    data-url-update-comment="{{ route('comments.update', $comment->id) }}"
                                >
                                    {{ trans('user.action.edit') }}
                                </button>
                                <button
                                    class="dropdown-item btn-delete-comment"
                                    data-message="{{ trans('user.message.confirm_delete') }}"
                                    data-url-delete-comment="{{ route('comments.destroy', $comment->id) }}"
                                >
                                    {{ trans('user.action.delete') }}
                                </button>
                            </ul>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
