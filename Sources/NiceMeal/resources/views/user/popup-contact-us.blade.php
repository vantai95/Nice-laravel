<div id="contactModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="add-to-card">
                <div class="add-to-card__header row" style="border-bottom: 0px;">
                    <div class="col-lg-12">
                        <h6>Nice Meal Support</h6>
                    </div>
                </div>
                <hr>
                <div class="add-to-card__content">
                    {!! Form::open([
                    'url' => '/contact-insert',
                    'class' => 'add-to-card__form',
                    'id' => 'submitForm', 'files' => true]) !!}
                        <div class="add-to-card__item" id="popup-contact">
                            <div class="form-item" >
                                <label class="form__label">Name<span>*</span></label>
                                <input class="form-control" type="text" name="name" placeholder="Enter your name" required autofocus >
                            </div>
                            <div class="form-item form-item--half" >
                                <label class="form__label">Email<span>*</span></label>
                                <input class="form-control" type="email" name="email" placeholder="Enter email" required >
                            </div>
                            <div class="form-item form-item--half" >
                                <label class="form__label">Phone<span>*</span></label>
                                <input class="form-control" type="tel" name="phone" placeholder="Enter phone number" required>
                            </div>
                            <div class="form-item ui-select-box">
                                <label for="contact_category_id" class="form__label">Select Category<span>*</span></label>
                                <select class="select2" id="contact_category_id" name="contact_category_id" style="width:100%;">
                                    @foreach($contact_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label class="form__label">Title<span>*</span></label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title" required >
                            </div>
                            <div class="form-item">
                                <label class="form__label">Message<span>*</span></label>
                                <textarea class="form-control" name="message" placeholder="Enter message" required></textarea>
                            </div>
                        </div>
                        <div class="add-to-card__footer">
                            <button type="button" class="btn md-btn--square pull-left" onclick="$('#file').trigger('click');">
                                <span class="fa fa-attach"></span> Attachment
                            </button>
                            <input type="file" id="file" style="display: none" name="file_attach"/>
                            <button type="submit" class="btn m-btn md-btn--danger">Send</button>
                        </div>
                    {!! Form::close() !!}
                </div>
                <button title="Close (Esc)" class="mfp-close" type="button" data-dismiss="modal">×</button>
            </div>
        </div>

    </div>
</div>
