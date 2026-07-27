/**
 * script.js
 * ---------------------------------------------------------
 * Handles:
 *  1. Submitting the add-user form via AJAX (fetch) without
 *     reloading the page.
 *  2. Toggling a user's status via AJAX.
 *  3. Re-rendering the users table dynamically.
 * ---------------------------------------------------------
 */

document.addEventListener('DOMContentLoaded', function () {
  const form        = document.getElementById('userForm');
  const submitBtn   = document.getElementById('submitBtn');
  const formMessage = document.getElementById('formMessage');
  const tableBody   = document.getElementById('usersTableBody');

  // ---------- Helper: show a message under the form ----------
  function showMessage(text, type) {
    formMessage.textContent = text;
    formMessage.className = 'form-message ' + type;
  }

  // ---------- Helper: build a single table row ----------
  function buildRow(user) {
    const tr = document.createElement('tr');
    tr.setAttribute('data-id', user.id);
    tr.classList.add('new-row');

    const isActive = Number(user.status) === 1;

    tr.innerHTML = `
      <td>${user.id}</td>
      <td>${escapeHtml(user.name)}</td>
      <td>${user.age}</td>
      <td>${escapeHtml(user.gender)}</td>
      <td class="status-cell">
        <span class="status-badge ${isActive ? 'active' : 'inactive'}">
          ${isActive ? 'Active 💗' : 'Inactive 🤍'}
        </span>
      </td>
      <td>
        <button class="btn-toggle" data-id="${user.id}">Toggle 🔄</button>
      </td>
    `;
    return tr;
  }

  // Basic escaping to avoid breaking markup with special characters
  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  // ---------- Render the full table from a list of users ----------
  function renderTable(users) {
    tableBody.innerHTML = '';

    if (!users || users.length === 0) {
      tableBody.innerHTML = `
        <tr class="empty-row">
          <td colspan="6">No users yet — be the first to add one! 🌷</td>
        </tr>`;
      return;
    }

    users.forEach(user => {
      tableBody.appendChild(buildRow(user));
    });
  }

  // ---------- Fetch all users from the server ----------
  function refreshUsers() {
    fetch('fetch_users.php')
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          renderTable(data.users);
        }
      })
      .catch(() => {
        // Silently ignore refresh errors; table just won't update this time
      });
  }

  // ---------- Handle form submission ----------
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    // Basic client-side validation for a snappier experience
    const name = formData.get('name').trim();
    const age  = formData.get('age');

    if (name.length < 2) {
      showMessage('Please enter a valid name (at least 2 letters). 🌷', 'error');
      return;
    }
    if (!age || age < 1 || age > 120) {
      showMessage('Please enter a valid age between 1 and 120. 🎂', 'error');
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding... ✨';

    fetch('add_user.php', {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showMessage(data.message, 'success');
          form.reset();
          refreshUsers(); // reload the table with the new user included
        } else {
          showMessage(data.message || 'Something went wrong. Please try again.', 'error');
        }
      })
      .catch(() => {
        showMessage('Network error. Please try again. 💭', 'error');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Add User 🌸';
      });
  });

  // ---------- Handle toggle button clicks (event delegation) ----------
  tableBody.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-toggle');
    if (!btn) return;

    const id = btn.getAttribute('data-id');
    const row = btn.closest('tr');

    btn.disabled = true;

    const body = new URLSearchParams();
    body.append('id', id);

    fetch('toggle_status.php', {
      method: 'POST',
      body: body
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const badge = row.querySelector('.status-badge');
          const isActive = Number(data.status) === 1;

          badge.className = 'status-badge ' + (isActive ? 'active' : 'inactive');
          badge.textContent = isActive ? 'Active 💗' : 'Inactive 🤍';

          // Little pulse animation to show the row changed
          row.classList.remove('just-updated');
          void row.offsetWidth; // force reflow so animation can replay
          row.classList.add('just-updated');
        } else {
          alert(data.message || 'Could not update status.');
        }
      })
      .catch(() => {
        alert('Network error while toggling status. 💭');
      })
      .finally(() => {
        btn.disabled = false;
      });
  });
});
