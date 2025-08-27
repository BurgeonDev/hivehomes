 <script>
     document.addEventListener('DOMContentLoaded', () => {
         const container = document.getElementById('productsContainer');
         const form = document.getElementById('productsFilterForm');
         const sortSel = document.getElementById('sortFilter');
         const categoriesList = document.getElementById('categoriesList');
         const conditionList = document.getElementById('conditionList');
         const resetBtn = document.getElementById('resetFilters');
         const routeUrl = '{{ route('products.index') }}';

         let selectedCategory = '{{ request('category_id', '') }}' || '';
         let selectedCondition = '{{ request('condition', '') }}' || '';

         function debounce(fn, wait) {
             let t;
             return (...args) => {
                 clearTimeout(t);
                 t = setTimeout(() => fn(...args), wait);
             };
         }

         function buildParams(page = null) {
             const s = (form.querySelector('[name=search]') || {
                 value: ''
             }).value || '';
             const sort = (sortSel && sortSel.value) || 'latest';
             const per_page = (document.getElementById('filterPerPage') && document.getElementById(
                 'filterPerPage').value) || '';
             const is_neg = (document.getElementById('filterNegotiable') && document.getElementById(
                 'filterNegotiable').checked) ? '1' : '';
             const is_feat = (document.getElementById('filterFeatured') && document.getElementById(
                 'filterFeatured').checked) ? '1' : '';

             const params = new URLSearchParams();
             if (s) params.set('search', s);
             if (sort) params.set('sort', sort);
             if (selectedCategory !== '' && selectedCategory !== null) params.set('category_id',
                 selectedCategory);
             if (selectedCondition !== '' && selectedCondition !== null) params.set('condition',
                 selectedCondition);
             if (is_neg) params.set('is_negotiable', is_neg);
             if (is_feat) params.set('is_featured', is_feat);
             if (per_page) params.set('per_page', per_page);
             if (page) params.set('page', page);
             return params;
         }

         async function fetchProducts(page = null) {
             try {
                 const params = buildParams(page);
                 const url = routeUrl + (params.toString() ? `?${params.toString()}` : '');
                 container.style.opacity = 0.5;

                 const resp = await fetch(url, {
                     method: 'GET',
                     credentials: 'same-origin',
                     headers: {
                         'X-Requested-With': 'XMLHttpRequest',
                         'Accept': 'text/html'
                     }
                 });
                 if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                 const html = await resp.text();
                 container.innerHTML = html;

                 // update URL without reload
                 const newUrl = new URL(window.location.href);
                 newUrl.search = params.toString();
                 window.history.replaceState({}, '', newUrl.toString());
             } catch (err) {
                 console.error('Failed to load products:', err);
                 container.innerHTML =
                     `<div class="card"><div class="card-body text-danger">Failed to load products. Try again.</div></div>`;
             } finally {
                 container.style.opacity = 1;
             }
         }

         const debouncedFetch = debounce(() => fetchProducts(), 300);

         // search input
         if (form) {
             form.addEventListener('submit', e => {
                 e.preventDefault();
                 fetchProducts();
             });
             const sInput = form.querySelector('[name=search]');
             if (sInput) sInput.addEventListener('input', debouncedFetch);
         }

         // sort change
         if (sortSel) sortSel.addEventListener('change', () => fetchProducts());

         // categories click
         if (categoriesList) {
             categoriesList.addEventListener('click', (e) => {
                 const item = e.target.closest('[data-cat]');
                 if (!item) return;
                 const newCat = item.getAttribute('data-cat') ?? '';
                 selectedCategory = (newCat === '') ? '' : String(newCat);
                 categoriesList.querySelectorAll('[data-cat]').forEach(el => el.classList.remove(
                     'active'));
                 item.classList.add('active');
                 fetchProducts();
             });
         }

         // condition click
         if (conditionList) {
             conditionList.addEventListener('click', (e) => {
                 const item = e.target.closest('[data-condition]');
                 if (!item) return;
                 selectedCondition = String(item.getAttribute('data-condition'));
                 conditionList.querySelectorAll('[data-condition]').forEach(el => el.classList.remove(
                     'active'));
                 item.classList.add('active');
                 fetchProducts();
             });
         }

         // toggles & per_page
         ['filterNegotiable', 'filterFeatured', 'filterPerPage'].forEach(id => {
             const el = document.getElementById(id);
             if (!el) return;
             el.addEventListener('change', () => fetchProducts());
         });

         // reset filters
         if (resetBtn) {
             resetBtn.addEventListener('click', () => {
                 if (form) form.reset();
                 if (sortSel) sortSel.value = 'latest';
                 selectedCategory = '';
                 selectedCondition = '';
                 if (categoriesList) {
                     categoriesList.querySelectorAll('[data-cat]').forEach(el => el.classList.remove(
                         'active'));
                     const all = categoriesList.querySelector('[data-cat=""]');
                     if (all) all.classList.add('active');
                 }
                 if (conditionList) conditionList.querySelectorAll('[data-condition]').forEach(el => el
                     .classList.remove('active'));
                 document.getElementById('filterNegotiable').checked = false;
                 document.getElementById('filterFeatured').checked = false;
                 document.getElementById('filterPerPage').value = '12';
                 fetchProducts();
             });
         }

         // pagination & links delegation
         container.addEventListener('click', (e) => {
             const a = e.target.closest('a');
             if (!a) return;
             const href = a.getAttribute('href') || '';
             if (!/page=/.test(href)) {
                 // not a pagination link, allow default
                 return;
             }
             e.preventDefault();
             try {
                 const url = new URL(href, window.location.origin);
                 const page = url.searchParams.get('page');
                 fetchProducts(page);
             } catch (err) {
                 fetchProducts();
             }
         });

     });
 </script>
