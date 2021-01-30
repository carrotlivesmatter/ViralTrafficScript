{include file="header.tpl"}


	<div class="row justify-content-center pb-4">
		<div class="col col-md-8">
			<div class="input-group input-group-lg">
				<input type="text" class="form-control" readonly="readonly" id="RefferalCode" onclick="this.select();" value="{$ref_link}">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" id="copyLink" data-toggle="popover" data-content="Link Copied!" type="button" data-clipboard-action="copy" data-clipboard-target="#RefferalCode">Copy Link!</button>
				</div>
			</div>
		</div>
	</div>

	<h3 class="text-center pb-4">You have referred <span class="badge badge-danger">{$referralViews}</span> people!</h3>

	<div class="row row-cols-1 row-cols-md-2">
			<div class="col mb-4">
				{if $referralViews < 5}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is  <small>5 needed</small></h5>
							<p class="card-text">You need to refer <span class="badge badge-danger">{5-$referralViews}</span> more people to unlock this content!</p>
						</div>
					</div>
				{else}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is unlocked</h5>
							<p class="card-text">You've referred enough people to see this content!</p>
						</div>
					</div>
				{/if}
			</div>
			<div class="col mb-4">
				{if $referralViews < 10}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is Locked <small>10 needed</small></h5>
							<p class="card-text">You need to refer <span class="badge badge-danger">{10-$referralViews}</span> more people to unlock this content!</p>
						</div>
					</div>
				{else}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is unlocked</h5>
							<p class="card-text">You've referred enough people to see this content!</p>
						</div>
					</div>
				{/if}
			</div>
			<div class="col mb-4">
				{if $referralViews < 20}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is Locked <small>20 needed</small></h5>
							<p class="card-text">You need to refer <span class="badge badge-danger">{20-$referralViews}</span> more people to unlock this content!</p>
						</div>
					</div>
				{else}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is unlocked</h5>
							<p class="card-text">You've referred enough people to see this content!</p>
						</div>
					</div>
				{/if}
			</div>
			<div class="col mb-4">
				{if $referralViews < 50}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is Locked <small>50 needed</small></h5>
							<p class="card-text">You need to refer <span class="badge badge-danger">{50-$referralViews}</span> more people to unlock this content!</p>
						</div>
					</div>
				{else}
					<div class="card text-center">
						<div class="card-body">
							<h5 class="card-title">Content is unlocked</h5>
							<p class="card-text">You've referred enough people to see this content!</p>
						</div>
					</div>
				{/if}
			</div>
		</div>
	</div>


</div>

{include file="footer.tpl"}