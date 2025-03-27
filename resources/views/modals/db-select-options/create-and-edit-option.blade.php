<div class="modal fade" id="modalCreateAndEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalTitle">Create or Edit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="formCreateAndEdit">
          @csrf
          @method('PATCH')
          <input type="hidden" id="id" name="id">
          <div class="mb-3">
              <label for="name" class="form-label">Option to display in the drop-down list</label>
              <input type="text" class="form-control" id="name" placeholder="" required>
          </div>
          <div class="mb-3">
            <select aria-label="Default select example" >
              <option selected>Hi, I'm an example of drop-down list</option>
              <option value="">Hi, I'm an example of option</option>
            </select>
          </div>
          {{--<div class="mb-3">--}}
          {{--<label for="optionalNote" class="form-label">Optional Note</label>--}}
            {{--<textarea class="form-control" id="optionalNote" rows="2"></textarea>--}}
              {{--</div>--}}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSave" form="formCreateAndEdit">Save</button>
      </div>
    </div>
  </div>
</div>
