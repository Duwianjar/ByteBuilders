<section>
    <h2>History List</h2>
    @if(session('success-transaction'))
        <div class="message">
            <p class="text-success mt-2">{{ session('success-transaction') }}</p>
        </div>
    @elseif(session('error-transaction'))
        <div class="message">
            <p class="text-danger mt-2">{{ session('error-transaction') }}</p>
        </div>
    @endif
    <div class="row justify-content-between d-flex">
        <div class="col-auto">
            <p class="mt-1">list of income and expenditure history from {{ $depository->name }}</p>
        </div>
        <div class="col-auto">
            <p class="add text-white bg-success rounded px-2" id="addButton">
                <i class="fas fa-plus"></i> Add History
            </p>
        </div>
    </div>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th style="min-width: 50px;">No</th>
                <th style="min-width: 150px;">Transaction</th>
                <th style="min-width: 150px;">Category</th>
                <th style="min-width: 200px;">Description</th>
                <th style="min-width: 150px;">Amount</th>
                <th style="min-width: 180px;" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="balance" value="{{ $depository->balance }}">
            @php $ada = 0; @endphp
            @if ($history->count())
            @php
                $page = request()->get('page', 1);
                $no = ($page - 1) * $history->perPage() + 1;
            @endphp
            @foreach ($history as $histo)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if ($histo->transaction == 0)
                        <td class="text-success">Earning</td>
                    @else
                        <td class="text-danger">Expense</td>
                    @endif
                    <td>{{ $histo->category->nama }}</td>
                    <td>{{ $histo->description }}</td>
                    @if ($histo->transaction == 0)
                        <td class="text-success">+{{ 'Rp. ' . number_format($histo->amount, 0, ',', '.') }}</td>
                    @else
                        <td class="text-danger">- {{ 'Rp. ' . number_format($histo->amount, 0, ',', '.') }}</td>
                    @endif
                    <td class="d-flex align-items-center">
                        <!-- Button to trigger the edit modal -->
                        <button type="button" class="btn btn-primary mx-2 edit-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $histo->id }}" data-id="{{ $histo->id }}" data-description="{{ $histo->description }}" data-amount="{{ $histo->amount }}" data-category="{{ $histo->category->nama }}" data-transaction="{{ $histo->transaction }}">Edit</button>
                        <form action="{{ route('histories.destroy', $histo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this history?');">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger" @if ($histo->amount > $depository->balance && $histo->transaction == 0) disabled @endif>Delete</button>
                        </form>
                    </td>
                </tr>
        
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $histo->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $histo->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $histo->id }}">Edit History</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editForm{{ $histo->id }}" method="POST" action="{{ route('histories.update', $histo->id) }}" >
                                @method('PUT')
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit-depository{{ $histo->id }}" class="form-label">Depository</label>
                                        <input type="text" class="form-control" id="edit-despository{{ $histo->id }}" name="edit-depository" value="{{ $depository->name }}" readonly>
                                     </div>
                                    <div class="mb-3">
                                        <label for="edit-transaction{{ $histo->id }}" class="form-label">Transaction Type</label>
                                        <select class="form-control" id="edit-transaction{{ $histo->id }}" name="edit-transaction">
                                            <option value="0" @if ($histo->transaction == 0) selected @endif>Earning</option>
                                            <option value="1" @if ($histo->transaction == 1) selected @endif>Expense</option>
                                        </select>
                                        <input type="hidden"  id="transaction-awal{{ $histo->id }}" value="{{ $histo->transaction }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-category{{ $histo->id }}" class="form-label">Category</label>
                                        <select class="form-control" id="edit-category{{ $histo->id }}" name="edit-id_category" required>
                                            <option value="">Select Category</option>
                                            @foreach ($category as $cate )
                                                <option value="{{ $cate->id }}" data-transaction="{{ $cate->transaction }}">{{ $cate->nama }}</option>
                                            @endforeach
                                            <option value="add_new">Add New Category</option>
                                        </select>
                                    </div>
            
                                    <div id="edit-newCategoryInput{{ $histo->id }}" class="mb-3 d-none" >
                                        <label for="newCategory" class="form-label">New Category</label>
                                        <input type="text" class="form-control" id="edit-newCategory{{ $histo->id }}" name="edit-new_category">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-description{{ $histo->id }}" class="form-label">Description</label>
                                        <textarea class="form-control" id="edit-description{{ $histo->id }}" name="edit-description" rows="3" required>{{ $histo->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-amount{{ $histo->id }}" class="form-label">Amount</label>
                                        <input type="text" class="form-control" id="edit-amount{{ $histo->id }}" name="edit-amount" value="{{ $histo->amount }}" required>
                                    </div>
                                </div>
                                <input type="hidden"  id="amount-awal{{ $histo->id }}" value="{{ $histo->amount }}" readonly>
                                <div class="modal-footer">
                                    <p class="text-warning d-none" id="no-change{{ $histo->id }}">Updates cannot be done because it will make the balance negative</p>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="update{{ $histo->id }}" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Edit Modal -->
            @if ($histo->amount > $depository->balance & $histo->transaction == 0)
                @php $ada++; @endphp 
            @endif
            @endforeach
            @if($ada>0)
                <tr>
                    <td colspan="6" class="text-warning float-end">Earnings history cannot be deleted because it will cause the balance to go negative</td>
                </tr>
            @endif
            @else
            <tr>
                <td colspan="6" class="text-warning">No history found.</td>
            </tr>
            @endif
            
        </tbody>
    </table>
    <div class="pagination">
        {{ $history->links() }}
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="addHistoryModal" tabindex="-1" aria-labelledby="addHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHistoryModalLabel">Add New History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($depository->balance <= 0)
                        <p style="font-size: 15px" class="text-danger">This depository has no balance, please add Earning history</p>
                    @endif
                    <!-- Form for adding new history -->
                    <form action="{{ route('histories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="depository" class="form-label">Depository</label>
                            <input type="text" class="form-control" id="despository" name="depository" value="{{ $depository->name }}" readonly>
                            <input type="hidden" class="form-control" id="id_despository" name="id_depository" value="{{ $depository->id }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="transactionType" class="form-label">Transaction</label>
                            <select class="form-control" id="transactionType" name="transaction">
                                <option value="0">Earning</option>
                                @if ($depository->balance <= 0)
                                    <option value="1" disabled>Expense - No Balance</option>
                                @else
                                    <option value="1">Expense</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="id_category" required>
                                <option value="">Select Category</option>
                                @foreach ($category as $cate )
                                    <option value="{{ $cate->id }}" data-transaction="{{ $cate->transaction }}">{{ $cate->nama }}</option>
                                @endforeach
                                <!-- Other options -->
                                <option value="add_new">Add New Category</option>
                            </select>
                        </div>

                        <div id="newCategoryInput" class="mb-3" style="display: none;">
                            <label for="newCategory" class="form-label">New Category</label>
                            <input type="text" class="form-control" id="newCategory" name="new_category">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                            <p class="d-none text-warning" id="amount-warning"> Expenses cannot be more than the balance</p>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Script to show modal when Add History button is clicked
    document.getElementById('addButton').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('addHistoryModal'), {
            keyboard: false
        });
        myModal.show();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var categorySelect = document.getElementById('category');
        var newCategoryInput = document.getElementById('newCategoryInput');

        if (categorySelect.value === 'add_new') {
            newCategoryInput.style.display = 'block';
            newCategoryInput.setAttribute('required', 'required');
        } else {
            newCategoryInput.style.display = 'none';
            newCategoryInput.removeAttribute('required');
        }

        categorySelect.addEventListener('change', function() {
            if (categorySelect.value === 'add_new') {
                newCategoryInput.style.display = 'block';
                newCategoryInput.setAttribute('required', 'required');
            } else {
                newCategoryInput.style.display = 'none';
                newCategoryInput.removeAttribute('required');
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const transactionSelect = document.getElementById('transactionType');
        const categorySelect = document.getElementById('category');
        const categoryOptions = categorySelect.querySelectorAll('option');
        var balance = document.getElementById('balance');
        var amount = document.getElementById('amount');
        var amountWarning = document.getElementById('amount-warning');

        transactionSelect.addEventListener('change', function() {
            var amountValue = parseFloat(amount.value);
            var balanceValue = parseFloat(balance.value); 
            const selectedTransaction = transactionSelect.value;
            if(selectedTransaction=="1"){
                if (amountValue >= balanceValue) {
                    amount.value = balanceValue;
                    amountWarning.classList.add('d-block'); 
                    amountWarning.classList.remove('d-none');
                } else {
                    amountWarning.classList.remove('d-block'); 
                    amountWarning.classList.add('d-none'); 
                }
            }
            else{
                amountWarning.classList.remove('d-block'); 
                amountWarning.classList.add('d-none'); 
            }
            categoryOptions.forEach(option => {
                if (option.dataset.transaction && option.dataset.transaction !== selectedTransaction) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                }
            });
        });

        // Trigger change event initially to initialize visibility based on initial selection
        transactionSelect.dispatchEvent(new Event('change'));
    });
</script>

<script>
    var balance = document.getElementById('balance');
    var amount = document.getElementById('amount');
    var amountWarning = document.getElementById('amount-warning');
    var type = document.getElementById('transactionType');

    amount.addEventListener('change', function() {
        var amountValue = parseFloat(amount.value);
        var balanceValue = parseFloat(balance.value); 
        if(type.value == "1"){

            if (amountValue >= balanceValue) {
                amount.value = balanceValue;
                amountWarning.classList.add('d-block'); 
                amountWarning.classList.remove('d-none');
            } else {
                amountWarning.classList.remove('d-block'); 
                amountWarning.classList.add('d-none'); 
            }
        }
        else{
            amountWarning.classList.remove('d-block'); 
            amountWarning.classList.add('d-none'); 
        }
    });

</script>


        
<script>
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetModalId = this.getAttribute('data-bs-target');
            const modal = new bootstrap.Modal(document.querySelector(targetModalId));
            modal.show();
        });
    });
</script>

<script>
    function findAndHideElement() {
        const hiddenElement = document.querySelector('.hidden');
        if (hiddenElement) {
            hiddenElement.classList.add('d-none');
            clearInterval(interval); 
        }
    }

    const interval = setInterval(findAndHideElement, 10); 
</script>




{{-- 
<script>
    const elements = document.querySelectorAll('[id^="edit-transaction"]');
    var balance = document.getElementById('balance');
    elements.forEach(element => {
        element.addEventListener('change', function() {
            var lastChar = element.id[element.id.length - 1];
            var amount = document.getElementById('edit-amount'+lastChar);
            var amountAwal = document.getElementById('amount-awal'+lastChar);
            var transactionAwal = document.getElementById('transaction-awal'+lastChar);
            var noChange = document.getElementById('no-change'+lastChar);
            var btnUpdate = document.getElementById('update'+lastChar);
            var balanceValue = parseFloat(balance.value); 
            var amountValue = parseFloat(amount.value);
            var awalValue = parseFloat(amountAwal.value);
            if(element.value == "1"){
                if(element.value != transactionAwal.value){
                    if(balanceValue < awalValue){
                        btnUpdate.disabled = true; 
                        noChange.classList.remove('d-none'); 
                        noChange.classList.add('d-block');
                    } else if(balanceValue < awalValue + amountValue){
                        btnUpdate.disabled = true; 
                        noChange.classList.remove('d-none'); 
                        noChange.classList.add('d-block');
                    } else {
                        btnUpdate.disabled = false; 
                        noChange.classList.add('d-none'); 
                        noChange.classList.remove('d-block');
                    }
                }else{
                    if(balanceValue<amountValue){
                        btnUpdate.disabled = true; 
                        noChange.classList.remove('d-none'); 
                        noChange.classList.add('d-block');
                    }else{
                        btnUpdate.disabled = false; 
                        noChange.classList.add('d-none'); 
                        noChange.classList.remove('d-block');
                    }
                }
            }else{
                btnUpdate.disabled = false; 
                noChange.classList.add('d-none'); 
                noChange.classList.remove('d-block');
            }

        });
    });
</script> --}}


{{-- 
<script>
    const elementAmounts = document.querySelectorAll('[id^="edit-amount"]');
    var balance = document.getElementById('balance');
    elementAmounts.forEach(element => {
        element.addEventListener('input', function() {
            var lastChar = element.id[element.id.length - 1];
            var transaction = document.getElementById('edit-transaction'+lastChar);
            var transactionAwal = document.getElementById('transaction-awal'+lastChar);
            var amountAwal = document.getElementById('amount-awal'+lastChar);
            var balanceValue = parseFloat(balance.value); 
            var elementValue = parseFloat(element.value); 
            var awalValue = parseFloat(amountAwal.value);
            if(transaction.value == "1"){
                if(transactionAwal.value == transaction.value){
                    if(elementValue > balanceValue + awalValue ){
                        this.value = balanceValue + awalValue;
                    }
                } else {
                    if(elementValue > balanceValue - awalValue ){
                        this.value = balanceValue - awalValue;
                    }
                }
            }
        });
    });
</script> --}}

{{-- <script>
    const elementEdits = document.querySelectorAll('[id^="edit-category"]');
    elementEdits.forEach(element => {
        element.addEventListener('change', function(event) {
            var lastChar = element.id[element.id.length - 1];
            var editCate = document.getElementById('edit-newCategoryInput'+lastChar);
            var inputEditCate = document.getElementById('edit-newCategory'+lastChar);
            if(element.value == "add_new"){
                inputEditCate.setAttribute('required', 'required');
                editCate.classList.add('d-block'); 
                editCate.classList.remove('d-none');
                console.log(editCate) 
            }else {
                editCate.classList.add('d-none'); 
                editCate.classList.remove('d-block'); 
                inputEditCate.removeAttribute('required');
                console.log(editCate) 
            }
            

        });
    });
</script> --}}


{{-- <script>
    const trans = document.querySelectorAll('[id^="edit-transaction"]');

    trans.forEach(element => {
        element.addEventListener('change', function() {
            var lastChar = element.id[element.id.length - 1];
            const editcategorySelect = document.getElementById('edit-category'+lastChar);
            const editCategoryOptions = editcategorySelect.querySelectorAll('option');
            editCategoryOptions.forEach(option => {
                if (option.dataset.transaction && option.dataset.transaction !== element.value) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                }
            });
            
        });
    });


</script> --}}



