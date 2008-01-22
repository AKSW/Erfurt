{section name=vars loop=$vars}
	{if $vars[vars].static}
	<a name="var{$vars[vars].var_name}" id="{$vars[vars].var_name}"><!-- Anchor --></a>
	<div class="{cycle values="evenrow,oddrow"}">
		<div class="var-header">
			<span class="var-title">
				static 
				<span class="var-type">{$vars[vars].var_type}</span>
				<span class="var-name">{$vars[vars].var_name}</span>
				{if $vars[vars].var_default} 
					= 
					<span class="var-default">{$vars[vars].var_default|replace:"\n":"<br />"}</span>
				{/if}
				{if $vars[vars].slink}
					(line <span class="line-number">{$vars[vars].slink}</span>)
				{/if}
			</span>
		</div>

		{include file="var_docblock.tpl" sdesc=$vars[vars].sdesc desc=$vars[vars].desc tags=$vars[vars].tags}	
	
		{if $vars[vars].var_overrides}
			<hr class="separator" />
			<div class="notes">Redefinition of:</div>
			<dl>
				<dt>{$vars[vars].var_overrides.link}</dt>
				{if $vars[vars].var_overrides.sdesc}
					<dd>{$vars[vars].var_overrides.sdesc}</dd>
				{/if}
			</dl>
		{/if}
	
		{if $vars[vars].descvar}
			<hr class="separator" />
			<div class="notes">Redefined in descendants as:</div>
			<ul class="redefinitions">
				{section name=vm loop=$vars[vars].descvar}
					<li>
					{$vars[vars].descvar[vm].link}
					{if $vars[vars].descvar[vm].sdesc}
						: {$vars[vars].descvar[vm].sdesc}
					{/if}
					</li>
				{/section}
			</ul>
		{/if}	
	</div>
	{/if}
{/section}

{section name=vars loop=$vars}
	{if !$vars[vars].static}
	<a name="var{$vars[vars].var_name}" id="{$vars[vars].var_name}"><!-- Anchor --></a>
	<div class="{cycle values="evenrow,oddrow"}">
		<div class="var-header">
			<span class="var-title">
				<span class="var-name">{$vars[vars].var_name}</span>
				{if $vars[vars].var_default} 
					= 
					<span class="var-default">{$vars[vars].var_default|replace:"\n":"<br />"}</span>
				{/if}
				{if $vars[vars].slink}
					(line <span class="line-number">{$vars[vars].slink}</span>)
				{/if}
			</span>
		</div>
		
		<div class="var-signature">
			<span class="var-type">{$vars[vars].var_type}</span>
			<span class="var-name">{$vars[vars].var_name}</span>
			{if $vars[vars].var_default} 
				= 
				<span class="var-default">{$vars[vars].var_default|replace:"\n":"<br />"}</span>
			{/if}
			{if $vars[vars].slink}
				(line <span class="line-number">{$vars[vars].slink}</span>)
			{/if}
		</div>

		{include file="var_docblock.tpl" sdesc=$vars[vars].sdesc desc=$vars[vars].desc tags=$vars[vars].tags}	
	
		{if $vars[vars].var_overrides}
			<hr class="separator" />
			<div class="notes">Redefinition of:</div>
			<dl>
				<dt>{$vars[vars].var_overrides.link}</dt>
				{if $vars[vars].var_overrides.sdesc}
					<dd>{$vars[vars].var_overrides.sdesc}</dd>
				{/if}
			</dl>
		{/if}
	
		{if $vars[vars].descvar}
			<hr class="separator" />
			<div class="notes">Redefined in descendants as:</div>
			<ul class="redefinitions">
				{section name=vm loop=$vars[vars].descvar}
					<li>
					{$vars[vars].descvar[vm].link}
					{if $vars[vars].descvar[vm].sdesc}
						: {$vars[vars].descvar[vm].sdesc}
					{/if}
					</li>
				{/section}
			</ul>
		{/if}	
	</div>
	{/if}
{/section}
