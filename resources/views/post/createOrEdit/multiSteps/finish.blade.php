
@extends('layouts.master')

@section('wizard')
	@includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard', 'post.createOrEdit.multiSteps.inc.wizard'])
@endsection

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (Session::has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-xl-12 page-content">

					@if (Session::has('success'))
						<div class="inner-box category-content">
							<div class="row">
								<div class="col-xl-12">
									<div class="alert alert-success pgray alert-lg mb-0" role="alert">
										<h2 class="no-margin no-padding">&#10004; {{ t('Congratulations') }}</h2>
										<p>{{ session('message') }} <a href="{{ url('/') }}">{{ t('Homepage') }}</a></p>
									</div>
								</div>
							</div>
						</div>
					@endif

				</div>
			</div>
		</div>
	</div>
@endsection
