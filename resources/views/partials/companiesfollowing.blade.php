          <section class="box-typical">
            <header class="box-typical-header-sm">
              Companies followed by {{ $user->first_name}} {{ $user->last_name}}
            </header>
                <div class="p-a-md">
            @if(count($user->following_pages) > 0)
              @foreach($user->following_pages as $page)
                  <div class="user-card-row">

                      <div class="tbl-cell tbl-cell-photo">
                        @if(count($page->photos)>0)
                          <img src="/photos/{{ $page->photos[0]->id }}.jpg" alt=""/>
                        @else
                          <img src="/img/default-company.png" alt=""/>
                        @endif

                      </div>
                    <h5><a href="/page/{{ $page->slug }}/{{ $page->id }}?current_user_id={{ $user->id }}">{{ $page->title }}</a></h5>
                  </div>
                  <br>
              @endforeach
                </div>

            @else
              <div class="p-a-md">
                This user is not following any companies yet.
              </div>
            @endif
          </section>
