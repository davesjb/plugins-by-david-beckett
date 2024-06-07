<div class="wrap">
    <h2>Form Entries</h2>

    <table id="form-submissions-table" class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th>ID</th>
                <th><a href="?page=shortcode-form-plugin-settings&orderby=fullname&order=<?php echo ($orderby === 'fullname' && $order == 'ASC' ? 'DESC' : 'ASC'); ?>">Fullname</a> </th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entries as $entry) : ?>
                <tr>
                    <td><?php echo $entry->id; ?></td>
                    <td class="editable" data-field="fullname" data-id="<?php echo $entry->id; ?>"><?php echo $entry->fullname; ?></td>
                    <td class="editable" data-field="email" data-id="<?php echo $entry->id; ?>"><?php echo $entry->email ?></td>
                    <td class="editable" data-field="phone" data-id="<?php echo $entry->id; ?>"><?php echo $entry->phone ?></td>
                    <td class="editable" data-field="message" data-id="<?php echo $entry->id; ?>"><?php echo $entry->message; ?></td>
                    <td><?php echo $entry->date_submitted; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cells = document.querySelectorAll('.editable');

        cells.forEach(function(cell) {
            cell.addEventListener('click', () => {
                if (cell.querySelector('input')) return;
                const fieldValue = cell.innerText;
                const input = document.createElement('input');
                // console.log(fieldValue);
                input.setAttribute('type', 'text');
                input.setAttribute('value', fieldValue);
                input.classList.add('form-control');
                input.addEventListener('blur', () => {
                    const newValue = input.value;
                    const field = cell.dataset.field;
                    const entryId = cell.dataset.id;
                    const formData = new FormData();
                    formData.append('update_entry', 'true');
                    formData.append('entry_id', entryId);
                    formData.append('field', field);
                    formData.append('new_value', newValue);
                    console.log(formData);
                    fetch(window.location.href, {
                        method: 'POST',
                        body: formData,
                    }).then(response => {
                        if (response.ok) {
                            cell.innerHTML = newValue;
                        } else {
                            alert('failed to update entry, please try again later');
                        }
                    }).catch(error => {
                        console.error("Error:" + error);
                        alert('An error occured while updating an entry');
                    });

                });

                cell.innerHTML = '';
                cell.appendChild(input);
                input.focus();
            });

        })
    });
</script>