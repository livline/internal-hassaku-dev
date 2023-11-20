
	<div class="container">
		<div class="containerInner clearfix">

			<div class="content">
				<div class="contentInner">

					<div class="pagettlWrap">
						<h1><?=$caption?></h1>
					</div>

					<div class="tableWrap borderLesstable">
						<div class="descriArea">
							<p><?=$message?></p>
						</div>
						<div class="descriArea" style="text-align:center">
							<?php if(isset($back_url)): ?>
							<p><a href="<?=$back_url?>">戻る</a></p>
							<?php else: ?>
							<p><a href="javascript:history.back();">戻る</a></p>
							<?php endif ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
