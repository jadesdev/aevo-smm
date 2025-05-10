
@if($service->type == 'poll')
<div class="form-group">
    <label>Link</label>
    <input class="form-control" required type="url" name="link" value="{{old('link')}}" placeholder="https://" id="" />
</div>
@endif
@if($service->type == 'custom_comments')
<div class="form-group">
    <label>Link</label>
    <input class="form-control" required type="url" name="link" value="{{old('link')}}" placeholder="https://" id="" />
</div>

<div class="form-group post_comment">
    <label for="post_comment"> Comments </label>
    <textarea rows="8" class="form-control" name="comments">{{old('comments')}}</textarea>
</div>
@endif

@if($service->type == 'mentions_custom_list')
<div class="form-group">
    <label>Link</label>
    <input class="form-control" required type="url" name="link" value="{{old('link')}}" placeholder="https://" id="" />
</div>

<div class="form-group post_comment">
    <label for="post_comment"> Usernames </label>
    <textarea rows="8" class="form-control" name="usernames">{{old('username')}}</textarea>
</div>
@endif

@if($service->type == 'mentions_user_followers')
<div class="form-group">
    <label>Link</label>
    <input class="form-control" required type="url" name="link" value="{{old('link')}}" placeholder="https://" id="" />
</div>

<div class="form-group username_input">
    <label for="username">Username </label>
    <input class="form-control" required name="username" value="{{old('username')}}" />
</div>

@endif

@if($service->type == 'default')
<div class="form-group">
    <label>Link</label>
    <input class="form-control" required type="url" name="link" value="{{old('link')}}" placeholder="https://" id="" />
</div>
@endif

@if($service->type == 'subscriptions')
<div class="row order-subscriptions">
    <div class="col-md-6">
      <div class="form-group">
        <label>Username</label>
        <input class="form-control square" type="text" name="sub_username" required>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>New posts</label>
        <input class="form-control square" type="number" placeholder="minimum 1 post" name="sub_posts" required>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Delay (minutes)</label>
        <select name="sub_delay" class="form-control square">
          <option value="0">No delay</option>
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="60">60</option>
          <option value="90">90</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>Expiry</label>
        <input type="date" class="form-control" name="sub_expiry" onkeydown="return false" placeholder="" id="expiry">
      </div>
    </div>

</div>
@endif
