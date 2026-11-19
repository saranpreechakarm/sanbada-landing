let unsaved = false;

document.querySelectorAll('form[data-confirm]').forEach(form => {
  form.addEventListener('submit', event => {
    if (!window.confirm(form.dataset.confirm)) event.preventDefault();
  });
});

document.querySelectorAll('[data-gallery-editor]').forEach(editor => {
  const grid = editor.querySelector('[data-gallery-items]');
  const input = editor.querySelector('[data-image-input]');
  const orderFields = editor.querySelector('[data-gallery-order]');
  const status = editor.querySelector('[data-gallery-status]');
  const newFiles = new Map();
  let nextId = 0;
  let dragged = null;
  editor.classList.add('gallery-enhanced');

  const cards = () => Array.from(grid.children);
  const removed = card => card.querySelector('[name="remove_images[]"]')?.checked;
  const activeCards = () => cards().filter(card => !removed(card));
  const announce = text => { status.textContent = text; };

  function sync() {
    const transfer = new DataTransfer();
    orderFields.replaceChildren();
    let position = 0;
    let newIndex = 0;
    cards().forEach(card => {
      const isRemoved = !!removed(card);
      card.classList.toggle('image-is-removed', isRemoved);
      card.classList.remove('is-cover');
      const label = card.querySelector('[data-image-position]');
      if (isRemoved) {
        label.textContent = 'นำรูปนี้ออกเมื่อบันทึก';
        return;
      }
      const isCover = position === 0;
      label.textContent = isCover ? 'รูปปก' : 'รูปที่ ' + (position + 1);
      card.classList.toggle('is-cover', isCover);
      const numericOrder = card.querySelector('[name^="image_order["]');
      if (numericOrder) numericOrder.value = position * 10;
      let token;
      if (card.dataset.existingIndex !== undefined) {
        token = 'old:' + card.dataset.existingIndex;
      } else {
        transfer.items.add(newFiles.get(card.dataset.newId).file);
        token = 'new:' + newIndex++;
      }
      const field = document.createElement('input');
      field.type = 'hidden';
      field.name = 'gallery_order[]';
      field.value = token;
      orderFields.append(field);
      position++;
    });
    input.files = transfer.files;
    announce(position + ' / 30 รูป · รูปแรกเป็นรูปปก' + (position > 30 ? ' — กรุณานำรูปออกให้เหลือไม่เกิน 30 รูป' : ''));
  }

  function move(card, action) {
    const active = activeCards();
    const index = active.indexOf(card);
    if (action === 'cover') {
      const checkbox = card.querySelector('[name="remove_images[]"]');
      if (checkbox) checkbox.checked = false;
      grid.prepend(card);
    } else if (action === 'previous' && index > 0) {
      grid.insertBefore(card, active[index - 1]);
    } else if (action === 'next' && index >= 0 && index < active.length - 1) {
      active[index + 1].after(card);
    } else {
      return;
    }
    unsaved = true;
    sync();
  }

  grid.addEventListener('click', event => {
    const card = event.target.closest('.sortable-image');
    if (!card) return;
    const moveButton = event.target.closest('[data-image-move]');
    if (moveButton) move(card, moveButton.dataset.imageMove);
    if (event.target.closest('[data-image-cover]')) move(card, 'cover');
    if (event.target.closest('[data-new-image-remove]')) {
      const record = newFiles.get(card.dataset.newId);
      URL.revokeObjectURL(record.url);
      newFiles.delete(card.dataset.newId);
      card.remove();
      unsaved = true;
      sync();
    }
  });
  grid.addEventListener('change', () => { unsaved = true; sync(); });
  grid.addEventListener('dragstart', event => {
    const card = event.target.closest('.sortable-image');
    if (!card || removed(card) || event.target.closest('input,button')) {
      event.preventDefault();
      return;
    }
    dragged = card;
    event.dataTransfer.effectAllowed = 'move';
    event.dataTransfer.setData('text/plain', 'project-image');
    card.classList.add('is-dragging');
  });
  grid.addEventListener('dragover', event => {
    if (!dragged) return;
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
    const target = event.target.closest('.sortable-image');
    if (!target || target === dragged) return;
    const rect = target.getBoundingClientRect();
    if (event.clientX > rect.left + rect.width / 2) target.after(dragged);
    else grid.insertBefore(dragged, target);
  });
  grid.addEventListener('drop', event => {
    if (!dragged) return;
    event.preventDefault();
    unsaved = true;
    sync();
  });
  grid.addEventListener('dragend', () => {
    if (dragged) {
      dragged.classList.remove('is-dragging');
      dragged = null;
      unsaved = true;
      sync();
    }
  });

  input.addEventListener('change', () => {
    const selected = Array.from(input.files);
    selected.forEach(file => {
      const id = String(nextId++);
      const url = URL.createObjectURL(file);
      newFiles.set(id, { file, url });
      const card = document.createElement('div');
      card.className = 'image-item sortable-image new-upload-image';
      card.dataset.newId = id;
      card.draggable = true;
      // This template is static. User-controlled filenames are inserted with textContent below.
      card.innerHTML = '<div class="image-sort-heading"><span class="sort-grip" aria-hidden="true">⠿</span><strong data-image-position></strong><span class="pill new">ใหม่</span></div><img draggable="false"><div class="image-sort-actions"><button type="button" data-image-move="previous" aria-label="เลื่อนรูปไปก่อนหน้า">←</button><button type="button" data-image-cover>ตั้งเป็นปก</button><button type="button" data-image-move="next" aria-label="เลื่อนรูปไปถัดไป">→</button></div><small class="upload-file-name"></small><button type="button" class="remove-new-image" data-new-image-remove>นำรูปนี้ออก</button>';
      const image = card.querySelector('img');
      image.src = url;
      image.alt = file.name;
      card.querySelector('.upload-file-name').textContent = file.name + ' · ' + (file.size / 1048576).toFixed(1) + ' MB';
      grid.append(card);
    });
    unsaved = true;
    sync();
  });

  try {
    const initial = JSON.parse(editor.dataset.initialOrder || '[]');
    initial.forEach(token => {
      const match = /^old:(\d+)$/.exec(token);
      if (match) {
        const card = cards().find(item => item.dataset.existingIndex === match[1]);
        if (card) grid.append(card);
      }
    });
    if (!initial.length) {
      cards().sort((left, right) => Number(left.querySelector('[name^="image_order["]').value) - Number(right.querySelector('[name^="image_order["]').value)).forEach(card => grid.append(card));
    }
  } catch { /* Keep the current order if a stale validation response contains no usable order. */ }
  sync();
});

document.querySelectorAll('[data-video-ratio]').forEach(select => {
  const form = select.closest('form');
  function updateAspect() {
    form.querySelector('[data-video-aspect-preview]').dataset.ratio = select.value;
    form.querySelector('[data-video-aspect-label]').textContent = select.value;
  }
  select.addEventListener('change', updateAspect);
  updateAspect();
});

document.querySelectorAll('[data-editor]').forEach(form => {
  form.addEventListener('input', () => { unsaved = true; });
  form.addEventListener('change', () => { unsaved = true; });
  form.addEventListener('submit', () => { unsaved = false; });
});
window.addEventListener('beforeunload', event => {
  if (unsaved) { event.preventDefault(); event.returnValue = ''; }
});

document.querySelectorAll("[data-print]").forEach(button => button.addEventListener("click", () => window.print()));
document.querySelectorAll("[data-auto-submit]").forEach(select => select.addEventListener("change", () => select.form.requestSubmit()));
