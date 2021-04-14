
@extends('errors.layouts.master')

@section('title', t('Too many requests'))

@section('search')
	@parent
	@include('errors.layouts.inc.search')
@endsection

@section('content')
	@include('common.spacer')
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						
						<div class="error-page mt-5 mb-5 ml-0 mr-0 pt-5">
							<h1 class="headline text-center" style="font-size: 180px;">429</h1>
							<div class="text-center m-l-0 mt-5">
								<h3 class="m-t-0 color-danger">
									<i class="fas fa-exclamation-triangle"></i> {{ t('Too many requests') }}
								</h3>
								<p>
									<?php
									$defaultErrorMessage = t('Meanwhile, you may return to homepage', ['url' => url('/')]);
									?>
									{!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage() : $defaultErrorMessage) : $defaultErrorMessage !!}
								</p>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
