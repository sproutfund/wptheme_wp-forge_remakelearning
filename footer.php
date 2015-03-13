<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.3.0
 */
?>
	<div class="row hide">
		<?php get_sidebar(); ?>
	</div>

	<footer id="footer" role="contentinfo">
		<div class="row">
			<div class="columns medium-10 medium-centered text-center">
				<?php get_template_part( 'footer', 'supporters' ); ?>
			</div>
		</div>
	</footer>
	
	<div id="secondary-sidebar" class="row widget-area" role="complementary">
		<div class="medium-12 large-12 columns">
			<div class="medium-6 large-8 columns">
				<?php get_template_part( 'footer', 'about' ); ?>
			</div>
			<div class="medium-6 large-4 columns">
				<?php get_template_part( 'footer', 'contact' ); ?>
			</div>
		</div>    
	</div>

	<div id="subfooter">
		<!--<ul class="inline-list right">
			<li><a href="/contact">Contact</a></li>
			<li><a href="/terms">Terms of Service</a></li>
			<li><a href="/privacy">Privacy Policy</a></li>
		</ul>-->
		<div style="margin-top: 1px;">
			<a title="remakelearning.org is licensed as Creative Commons Attribution-NonCommercial-ShareAlike 3.0" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.en_US">
				<img alt="Creative Commons License" style="border:0;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png">
			</a>
			<span class="license-text">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 License</span>
		</div>
	</div>
    
    </div><!-- #wrapper -->
    
<?php if( get_theme_mod( 'wpforge_mobile_display' ) == 'yes') { ?>    
    
	  <a class="exit-off-canvas"></a>
      
	</div><!-- .inner-wrap -->
    
</div><!-- #off-canvas-wrap -->

<?php } // end if ?>
    
    <div id="backtotop">Top</div><!-- #backtotop -->

<?php wp_footer(); ?>

	<script type="text/javascript">
		jQuery(document).foundation();

		jQuery('#cover_story_primary-image').hover(function(event) {
			jQuery('#cover_story_primary-area').toggleClass('medium-7')
			jQuery('#cover_story_primary-area').toggleClass('medium-12')
			jQuery('#cover_story_primary-image').toggleClass('medium-12')
			jQuery('#cover_story_primary-image').toggleClass('medium-7')
			jQuery('#cover_story_primary-excerpt').toggle()
			jQuery('#more-blog_entries').toggle()
		}); 
		jQuery('#cover_story_secondary-image').hover(function(event) {
			jQuery('#cover_story_secondary-area').toggleClass('large-8 large-push-4')
			jQuery('#cover_story_secondary-area').toggleClass('large-12')
			jQuery('#cover_story_secondary-image').toggleClass('large-12')
			jQuery('#cover_story_secondary-image').toggleClass('large-8 large-push-4')
			jQuery('#cover_story_secondary-excerpt').toggle()
			jQuery('#more-recent_news').toggle()
		});
	</script>
	
<!--begin Google Analytics & Usabilla-->
<?php if( get_current_blog_id() == 3 ) : ?>
	<script type="text/javascript">/*{literal}<![CDATA[*/(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-8341602-3', 'auto'); ga('require', 'linkid', 'linkid.js'); ga('send', 'pageview'); /*]]>{/literal}*/</script>
	<script type="text/javascript">/*{literal}<![CDATA[*/ if (Modernizr.mq('only screen and (min-width: 641px)')) { window.lightningjs||function(c){function g(b,d){d&&(d+=(/\?/.test(d)?"&":"?")+"lv=1");c[b]||function(){var i=window,h=document,j=b,g=h.location.protocol,l="load",k=0;(function(){function b(){a.P(l);a.w=1;c[j]("_load")}c[j]=function(){function m(){m.id=e;return c[j].apply(m,arguments)}var b,e=++k;b=this&&this!=i?this.id||0:0;(a.s=a.s||[]).push([e,b,arguments]);m.then=function(b,c,h){var d=a.fh[e]=a.fh[e]||[],j=a.eh[e]=a.eh[e]||[],f=a.ph[e]=a.ph[e]||[];b&&d.push(b);c&&j.push(c);h&&f.push(h);return m};return m};var a=c[j]._={};a.fh={};a.eh={};a.ph={};a.l=d?d.replace(/^\/\//,(g=="https:"?g:"http:")+"//"):d;a.p={0:+new Date};a.P=function(b){a.p[b]=new Date-a.p[0]};a.w&&b();i.addEventListener?i.addEventListener(l,b,!1):i.attachEvent("on"+l,b);var q=function(){function b(){return["<head></head><",c,' onload="var d=',n,";d.getElementsByTagName('head')[0].",d,"(d.",g,"('script')).",i,"='",a.l,"'\"></",c,">"].join("")}var c="body",e=h[c];if(!e)return setTimeout(q,100);a.P(1);var d="appendChild",g="createElement",i="src",k=h[g]("div"),l=k[d](h[g]("div")),f=h[g]("iframe"),n="document",p;k.style.display="none";e.insertBefore(k,e.firstChild).id=o+"-"+j;f.frameBorder="0";f.id=o+"-frame-"+j;/MSIE[ ]+6/.test(navigator.userAgent)&&(f[i]="javascript:false");f.allowTransparency="true";l[d](f);try{f.contentWindow[n].open()}catch(s){a.domain=h.domain,p="javascript:var d="+n+".open();d.domain='"+h.domain+"';",f[i]=p+"void(0);"}try{var r=f.contentWindow[n];r.write(b());r.close()}catch(t){f[i]=p+'d.write("'+b().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};a.l&&setTimeout(q,0)})()}();c[b].lv="1";return c[b]}var o="lightningjs",k=window[o]=g(o);k.require=g;k.modules=c}({}); window.usabilla_live = lightningjs.require("usabilla_live", "//w.usabilla.com/ea52afbc023e.js"); } /*]]>{/literal}*/</script>
	<?php elseif( get_current_blog_id() == 10 ) : ?>
	<script type="text/javascript">/*{literal}<![CDATA[*/(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-8341602-2', 'auto'); ga('require', 'linkid', 'linkid.js'); ga('send', 'pageview'); /*]]>{/literal}*/</script>
	<script type="text/javascript">/*{literal}<![CDATA[*/window.lightningjs||function(c){function g(b,d){d&&(d+=(/\?/.test(d)?"&":"?")+"lv=1");c[b]||function(){var i=window,h=document,j=b,g=h.location.protocol,l="load",k=0;(function(){function b(){a.P(l);a.w=1;c[j]("_load")}c[j]=function(){function m(){m.id=e;return c[j].apply(m,arguments)}var b,e=++k;b=this&&this!=i?this.id||0:0;(a.s=a.s||[]).push([e,b,arguments]);m.then=function(b,c,h){var d=a.fh[e]=a.fh[e]||[],j=a.eh[e]=a.eh[e]||[],f=a.ph[e]=a.ph[e]||[];b&&d.push(b);c&&j.push(c);h&&f.push(h);return m};return m};var a=c[j]._={};a.fh={};a.eh={};a.ph={};a.l=d?d.replace(/^\/\//,(g=="https:"?g:"http:")+"//"):d;a.p={0:+new Date};a.P=function(b){a.p[b]=new Date-a.p[0]};a.w&&b();i.addEventListener?i.addEventListener(l,b,!1):i.attachEvent("on"+l,b);var q=function(){function b(){return["<head></head><",c,' onload="var d=',n,";d.getElementsByTagName('head')[0].",d,"(d.",g,"('script')).",i,"='",a.l,"'\"></",c,">"].join("")}var c="body",e=h[c];if(!e)return setTimeout(q,100);a.P(1);var d="appendChild",g="createElement",i="src",k=h[g]("div"),l=k[d](h[g]("div")),f=h[g]("iframe"),n="document",p;k.style.display="none";e.insertBefore(k,e.firstChild).id=o+"-"+j;f.frameBorder="0";f.id=o+"-frame-"+j;/MSIE[ ]+6/.test(navigator.userAgent)&&(f[i]="javascript:false");f.allowTransparency="true";l[d](f);try{f.contentWindow[n].open()}catch(s){a.domain=h.domain,p="javascript:var d="+n+".open();d.domain='"+h.domain+"';",f[i]=p+"void(0);"}try{var r=f.contentWindow[n];r.write(b());r.close()}catch(t){f[i]=p+'d.write("'+b().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};a.l&&setTimeout(q,0)})()}();c[b].lv="1";return c[b]}var o="lightningjs",k=window[o]=g(o);k.require=g;k.modules=c}({}); window.usabilla_live = lightningjs.require("usabilla_live", "//w.usabilla.com/c2d918df5db9.js"); /*]]>{/literal}*/</script>
<?php endif; ?>
<!--end Google Analytics & Usabilla-->
Modernizr.mq('only screen and (max-width: 768px)')
</body>
</html>
<?php //ob_end_flush(); ?>