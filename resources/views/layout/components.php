<!-- About -->

<div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" id="exampleModalLongTitle"><?= _('About'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="content-text-modal">
          <p><?= ABOUT_DESCRIPTION; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- // about -->
<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="imageModal">imageModal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="bscallout form-text mb-3 mt-3">Si vous uploader vos images via FTP, déposez-les dans le dossier /public/uploads/</div>
        <form>
          <div class="form-group">
            <label for="imageUrl">Image URL</label>
            <input type="text" class="form-control" id="imageUrl" placeholder="Enter image URL">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="insert-image-button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="galleryModalLabel">Ajouter une gallerie de photos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="bscallout form-text mb-3 mt-3">Si vous uploader vos images via FTP</div>
          <div class="form-group mb-3">
            <label for="url1">Image URL 1</label>
            <input type="text" class="form-control" id="url1" placeholder="Enter image URL">
          </div>
          <div class="form-group mb-3">
            <label for="url2">Image URL 2</label>
            <input type="text" class="form-control" id="url2" placeholder="Enter image URL">
          </div>
          <div class="form-group mb-3">
            <label for="url3">Image URL 3</label>
            <input type="text" class="form-control" id="url3" placeholder="Enter image URL">
          </div>
          <div class="form-group mb-3">
            <label for="url4">Image URL 4</label>
            <input type="text" class="form-control" id="url4" placeholder="Enter image URL">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="insert-gallery-button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- shortCodeModal -->
<div class="modal fade" id="shortCodeModal" tabindex="-1" role="dialog" aria-labelledby="shortCodeModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" id="exampleModalLongTitle"><?= _("Shortcode List"); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="content-text-modal">
          <p><?= _("Add an image shortcode"); ?><br>
            <code>[image url="path/to/image.jpg"]</code>
          </p>
          <p><?= _("Add an image gallery shortcode"); ?> <br>
            <code>[gallery url1="path/to/image.jpg" url2="path/to/image.jpg" url3="path/to/image.jpg" url4="path/to/image.jpg"]</code>
          </p>
          <p><?= _("Add a caption shortcode"); ?><br>
            <code>[caption text="caption goes here"]</code>
          </p>
          <p><?= _("Add a Youtube video shortcode"); ?><br>
            <code>[youtube id="hf4ji48276h"]</code>
          </p>
          <p><?= _("Add an quote shortcode"); ?><br>
            <code>[blockquote text="type your text here."]</code>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Backdrop with scrolling</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ol class="list-group">
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <div class="fw-bold">Subheading</div>
          Content for list item
        </div>
        <span class="badge bg-primary rounded-pill">14</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <div class="fw-bold">Subheading</div>
          Content for list item
        </div>
        <span class="badge bg-primary rounded-pill">14</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <div class="fw-bold">Subheading</div>
          Content for list item
        </div>
        <span class="badge bg-primary rounded-pill">14</span>
      </li>
    </ol>
  </div>
</div>