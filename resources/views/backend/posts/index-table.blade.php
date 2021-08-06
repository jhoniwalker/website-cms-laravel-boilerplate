<div class="table-responsive">
    <table class="table">
        <thead>
            <th>Title</th>
            <th>Published</th>
            <th>Featured</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                        <div class='btn-group'>
                            <form method="POST" action="{{ route('admin.posts.table-switches', $post->id) }}">
                                {!! csrf_field() !!}
                                {{ method_field('PUT') }}
                                <label class="c-switch c-switch-label c-switch-primary">
                                    <input type="hidden" name="published" value="off" />
                                    <input class="c-switch-input" type="checkbox" onClick="this.form.submit()"
                                        name="published" id="published" {{ $post->published == 1 ? ' checked' : '' }}>
                                    <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                </label>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class='btn-group'>
                            <form method="POST" action="{{ route('admin.posts.table-switches', $post->id) }}">
                                {!! csrf_field() !!}
                                {{ method_field('PUT') }}
                                <label class="c-switch c-switch-label c-switch-primary">
                                    <input type="hidden" name="featured" value="off" />
                                    <input class="c-switch-input" type="checkbox" onClick="this.form.submit()"
                                        name="featured" id="featured"
                                        {{ $post->featured == 1 ? ' checked' : '' }}>
                                    <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                </label>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class='btn-group'>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}">
                                {!! csrf_field() !!}
                                {{ method_field('DELETE') }}

                                <a href="{{ route('admin.posts.edit', $post) }}" class='btn btn-primary btn-sm'>
                                    <span class="fas fa-edit"></span>
                                </a>

                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('¿Estás seguro de borrar el registro?')">
                                    <span class="fas fa-trash"></span>
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
