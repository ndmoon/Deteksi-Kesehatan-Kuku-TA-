<footer class="pc-footer">
  <div class="footer-wrapper container-fluid">
    <div class="row">
      <div class="col-sm my-1">
        <!-- Footer -->
        <medium>© {{ date('Y') }} CEKU. All rights reserved.</medium>
      </div>
    </div>
  </div>
</footer>

<!-- [Scripts] -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script>feather.replace();</script>

@stack('scripts')
