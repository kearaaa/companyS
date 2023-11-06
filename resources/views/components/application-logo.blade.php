@if (request()->is('*edit/*'))
  <img src="../../assets/hummasoft (1)600.png" alt="" {{ $attributes }}>
@else
  <img src="assets/hummasoft (1)600.png" alt="" {{ $attributes }}>
@endif
