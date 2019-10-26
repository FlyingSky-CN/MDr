<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
            <div class="mdui-typo" style="margin-top: 32px;margin-bottom: 32px;">
                &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php if ($this->options->mdrCopytext): $this->options->mdrCopytext(); else: $this->options->title(); endif; ?></a>. Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a> & <a href="https://blog.fsky7.com/archives/60/">MDr</a>.<br>
                <?php if (!empty($this->options->ButtomText)): ?>
                <?=$this->options->ButtomText?>
                <?php endif; ?>
		  <?php if ($this->options->mdrHitokoto): ?>
                <script type="text/javascript" src="https://api.lwl12.com/hitokoto/v1?encode=js&charset=utf-8"></script><span id="lwlhitokoto"><script>lwlhitokoto()</script></span><br>
                <?php endif;  ?>
                <?php if ($this->options->SiteTime): ?>
                博客已上线 <span id="runtime_span"></span> .
                <script>function show_runtime(){window.setTimeout("show_runtime()",1000);X=new Date("<?=$this->options->SiteTime?>");Y=new Date();T=(Y.getTime()-X.getTime());M=24*60*60*1000;a=T/M;A=Math.floor(a);b=(a-A)*24;B=Math.floor(b);c=(b-B)*60;C=Math.floor((b-B)*60);D=Math.floor((c-C)*60);runtime_span.innerHTML=""+A+" 天 "+B+" 时 "+C+" 分 "+D+" 秒"}show_runtime();</script>
                <?php endif; ?>
                <?php if ($this->options->ICPbeian): ?>
                <br><a href="http://beian.miit.gov.cn" target="_blank"><?php $this->options->ICPbeian(); ?></a>
                <?php endif; ?>
				<?php if (($this->options->beianProvince) && ($this->options->beianNumber)): ?>
                <br><img src="data:image/png;base64,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0p8zAAA7SGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS41LWMwMjEgNzkuMTU1NzcyLCAyMDE0LzAxLzEzLTE5OjQ0OjAwICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgICAgICAgICB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIgogICAgICAgICAgICB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmV4aWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vZXhpZi8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdG9yVG9vbD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxNCAoV2luZG93cyk8L3htcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTUtMTEtMTBUMTQ6MDQ6NTArMDg6MDA8L3htcDpDcmVhdGVEYXRlPgogICAgICAgICA8eG1wOk1ldGFkYXRhRGF0ZT4yMDE1LTExLTEwVDE0OjA0OjUwKzA4OjAwPC94bXA6TWV0YWRhdGFEYXRlPgogICAgICAgICA8eG1wOk1vZGlmeURhdGU+MjAxNS0xMS0xMFQxNDowNDo1MCswODowMDwveG1wOk1vZGlmeURhdGU+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnhtcC5paWQ6ODBiY2E5ODUtNGY5Yi02ZTRkLTlmYzktZThmNDkyNjdkZjRlPC94bXBNTTpJbnN0YW5jZUlEPgogICAgICAgICA8eG1wTU06RG9jdW1lbnRJRD5hZG9iZTpkb2NpZDpwaG90b3Nob3A6ZWRkYWU4MGMtODc3MC0xMWU1LTg0OWEtYmNmZGE2MDI4ZjJlPC94bXBNTTpEb2N1bWVudElEPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6ZDAxN2I5NGUtOTRiZC0yNjQxLThmZjktYmY3YTBhMzY3N2IxPC94bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpIaXN0b3J5PgogICAgICAgICAgICA8cmRmOlNlcT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+Y3JlYXRlZDwvc3RFdnQ6YWN0aW9uPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6aW5zdGFuY2VJRD54bXAuaWlkOmQwMTdiOTRlLTk0YmQtMjY0MS04ZmY5LWJmN2EwYTM2NzdiMTwvc3RFdnQ6aW5zdGFuY2VJRD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OndoZW4+MjAxNS0xMS0xMFQxNDowNDo1MCswODowMDwvc3RFdnQ6d2hlbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OnNvZnR3YXJlQWdlbnQ+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKFdpbmRvd3MpPC9zdEV2dDpzb2Z0d2FyZUFnZW50PgogICAgICAgICAgICAgICA8L3JkZjpsaT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo4MGJjYTk4NS00ZjliLTZlNGQtOWZjOS1lOGY0OTI2N2RmNGU8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTUtMTEtMTBUMTQ6MDQ6NTArMDg6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE0IChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgIDwvcmRmOlNlcT4KICAgICAgICAgPC94bXBNTTpIaXN0b3J5PgogICAgICAgICA8cGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPgogICAgICAgICAgICA8cmRmOkJhZz4KICAgICAgICAgICAgICAgPHJkZjpsaT4zQ0I4RkVFOEMyRUJFNkU1QTREQTk3MzI4MzU0MTI0RTwvcmRmOmxpPgogICAgICAgICAgICAgICA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDpiZGRmY2Y2Zi04NzcwLTExZTUtODQ5YS1iY2ZkYTYwMjhmMmU8L3JkZjpsaT4KICAgICAgICAgICAgPC9yZGY6QmFnPgogICAgICAgICA8L3Bob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4KICAgICAgICAgPHBob3Rvc2hvcDpDb2xvck1vZGU+MzwvcGhvdG9zaG9wOkNvbG9yTW9kZT4KICAgICAgICAgPHBob3Rvc2hvcDpJQ0NQcm9maWxlPnNSR0IgSUVDNjE5NjYtMi4xPC9waG90b3Nob3A6SUNDUHJvZmlsZT4KICAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9wbmc8L2RjOmZvcm1hdD4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+MTwvZXhpZjpDb2xvclNwYWNlPgogICAgICAgICA8ZXhpZjpQaXhlbFhEaW1lbnNpb24+MjA8L2V4aWY6UGl4ZWxYRGltZW5zaW9uPgogICAgICAgICA8ZXhpZjpQaXhlbFlEaW1lbnNpb24+MjA8L2V4aWY6UGl4ZWxZRGltZW5zaW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAKPD94cGFja2V0IGVuZD0idyI/Pu6JurQAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAABRFJREFUeNpE1OtvW/Udx/H3ufj4+Ph2nDh2vLgrTSPaFNqGtd0Gy9LRTVymNoNM6ihCaEwdQ5sYAo0HTOwBYg/Yk0pDiG3qmLSiPtjGJERbdZSQaUArykXt1la9hDRNY6dpYsexj30uPj7ntwcVyT/w0ucrfT5fSQgBdguAEBlZhDhaiVikF2j22lfPjP77+Kc/9ZyO9p37th7s2rLlbegveZ4g6jggS4AMAKkkkhAC366DJJADgaJlgA/unTx+4qmT/7oyKpxJfdYzUDIma7M6TsXoDH+3/8jgnrG/iOC2o8JrIiQJECjpvlt0Q7JoimWEkQHN1Sf+8MbE40+O7226M/rtCYX9+k2e0me55+48XXfn1f1PvvfwiVdfOSLFlKitSbh8hq9+DitZFRlZSaHK1aJ35uV3f3+4zr79/fy42CD9pwtULwdUpwLqu//ID4JzPHPoEQ7+00dc/vM/Eoary3oCPR5dBROeRTxaH7x+9MWpkd3nRsyBPL/InmP6cAN5jUlgtcELkXpMTj19kr3GGfLfuovv7T62Z/GjN67aM2c3XHz/nVUw6jmo7ruJI5eT2idz23lwu0XzbAP5eh3JjBJdCnBP3iSyrhu96VD562nG7m8z8cUm3vwwKCSkVgx5aBWsL1aK4cfvHwilGKg2KWuOxjxEAh+WXKT1Bto2E/lGC42QyrRDX5cHkkStKRPtUQ9sHB5btwLOXHrvh+1yeTiT0KATRRQKZId7aSKw7ukm2Fck8dIQxjNbkHsMctuytOw2CEEhZ0Dp7L1Ls6d+sgIaicxgw/Lp73FB7+bEaQN1V4rqnrUEZQvpfy3sYzfxp5fRnh+m69mtvHWoBsQZ2qzSmlrALU0VV8BwaW5Po6ZyZ9Gi+HWN19+M859XSgztKJA2ktgXaoQLHu65GsnyMudfvsKrh6Lkh0w299WplD38pUvDK6CstkyrIZNavMLe+wM6fgL/6Dzdf/scuS9Cu0chzKlkdxUoTFylcvA8rbbC2GiEZHUSq6GiJuUIgAoQM746Lm+4Nhrk+3jiGxYH+np4vTyIP3uB7uokcjqGc6GGNZCjnCnwdzkGKZMnvrlAJ1nEvEPCyKw5tgKCnBMNwdyUxZ2D0/z2V9t48fkRjlqboeEzalfpMmXeOpakiQFkeO7nOjsGJpmbBFybsGNtXQFVs729k8zjz/uUFi7yy+EoY+NxJo7bXJK38MCmLyjEKnSO9NGuOazZaPDrB65x89Q1bF9Hz2qoprYRuPUcvOYnj1ZP/+6wM9/Gq/hQmmH9Q0NE8zoEVYKqSnPBIb2uC9Z2Q6nC9NuXcZJZEv0JYr0G6YF9O7XM9z+QhBAAdFr/fWzp/IHXAtdJVz6cR40LencOEiw5+HYL2dDRu+JIWoTqqSk6gUp6+3p8l2p6w8gjcTM1Lmn33TrZd2ZwFp2yOx9z9HyYzu8aIKi3CKwGGBqKZqLFoL3cpFWqoa/tRi/m8ZZt3LIlYmuaKKkUsS9rI9pXUfjohdzXkr2RTAGvHhIGKmGg4C5aIELa1TrNyUUkJQKShHujQiQmk/92IasZ1s9Ch9Uta0qKaPeOhyw7/ZpdKrU0ZZlUrkNEstEkH8VbRjgOyY1ZUgMpZK2JmtaQMr3XO+pdv1GN23+kaIus1kb4SBHVblTjTzsX8y859cUHPX9251c29WwKLSmhm3KXGkti3eB6rMe01dzI2aWphXFnpnaib2culBQFEbgA/H8ALiI3EysggNoAAAAASUVORK5CYII=" alt="公网安备案图标"><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php $this->options->beianNumber(); ?>" target="_blank"><?php $this->options->beianProvince(); ?>公网安备 <?php $this->options->beianNumber(); ?>号</a>
                <?php endif; ?>
            </div>
        </div>
        
<div class="mdui-fab-fixed" style="z-index: 9999;" id="cornertool">
<?php if ($this->options->scrollTop): ?>
<div class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white mdui-fab-hide" style="display:block;margin-top:8px;" id="top">
	<i class="mdui-icon material-icons"></i>
</div>
<?php endif; ?>
<?php if ($this->options->DarkMode): ?>
<div class="mdui-fab mdui-ripple mdui-fab-mini mdui-color-white" onclick="switchDarkMode()" style="display:block;margin-top:8px;">
	<i class="mdui-icon material-icons">brightness_4</i>
</div>
<?php endif; ?>
<?php if ($this->options->MusicSet && $this->options->MusicUrl): ?>
<li id="music" class="hidden">
<span><i></i></span>
<audio id="audio" preload="none"></audio>
</li>
<?php endif; ?>
</div>


<!-- MDUI STR -->
<script src="//<?php if ($this->options->mdrMDUICDN == 'bootcss'): ?>cdn.bootcss.com/mdui/0.4.2/js/mdui.min.js<?php elseif ($this->options->mdrMDUICDN == 'cdnjs'): ?>cdnjs.cloudflare.com/ajax/libs/mdui/0.4.3/js/mdui.min.js<?php else: ?>cdnjs.loli.net/ajax/libs/mdui/0.4.3/js/mdui.min.js<?php endif; ?>"></script>
<!-- MDUI END -->
<?php if ($this->options->PjaxOption || $this->options->AjaxLoad || $this->options->ViewImg): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery/3.4.1/jquery.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js<?php endif; ?>"></script>
<?php endif; if ($this->options->PjaxOption): ?>
<script src="//<?php if ($this->options->cjCDN == 'bc'): ?>cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js<?php elseif ($this->options->cjCDN == 'cf'): ?>cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js<?php else: ?>cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.min.js<?php endif; ?>"></script>
<script>
jQuery.fn.Shake = function(n, d) {
	this.each(function() {
		var jSelf = $(this);
		jSelf.css({
			position: 'relative'
		});
		for (var x = 1; x <= n; x++) {
			jSelf.animate({
				left: ( - d)
			},
			50).animate({
				left: d
			},
			50).animate({
				left: 0
			},
			50)
		}
	});
	return this
};
$(document).pjax('a[target!=_blank]', { 
	container: '#main',
	fragment: '#main',
	timeout: 10000
}).on('submit', 'form[id=search], form[id=comment-form]',
function(event) {
	$.pjax.submit(event, {
		container: '#main',
		fragment: '#main',
		timeout: 10000
	})
}).on('pjax:send',
function() {
	$('#loading').fadeIn();
}).on('pjax:complete',
function() {
	setTimeout(function() {
		$("#loading").fadeOut()
	},
	300);
	$('#header').removeClass("on");
	$('#s').val(""); <?php if ($this->options->SidebarFixed) : ?>$("#secondary").removeAttr("style"); <?php endif; ?>
}).on('pjax:end',
function() {
    mdrcd();
	<?php if ($this->options->AjaxLoad) : ?>al(); <?php endif; ?>cl();
	ac();
	ap(); 
	<?php if ($this->options->CustomContent) : ?>
	if (typeof _hmt !== 'undefined') {
		_hmt.push(['_trackPageview', location.pathname + location.search])
	};
	if (typeof ga !== 'undefined') {
		ga('send', 'pageview', location.pathname + location.search)
	} 
	<?php endif; ?>
});
function mdrcd() {
    if ( document.body.clientWidth < 1024 ) {
        mdui.Drawer('#mdrDrawerL').close();
        mdui.Drawer('#mdrDrawerR').close();
    }
}
function ac() {
	$body = $('html,body');
	var g = '.comment-list',
	h = '.comment-num',
	i = '.comment-reply a',
	j = '#textarea',
	k = '',
	l = '';
	c();
	$('#comment-form').submit(function() {
        mdui.snackbar({
            message: '评论正在发送中...',
            position: 'right-top',
            timeout: 5000
        });
		$.ajax({
			url: $(this).attr('action'),
			type: 'post',
			data: $(this).serializeArray(),
			error: function() {
                mdui.snackbar({
                    message: '提交失败，请检查网络并重试或者联系管理员。',
                    position: 'right-top',
                    timeout: 5000
                });
				return false
			},
			success: function(d) {
				if (!$(g, d).length) {
					mdui.snackbar({
                        message: '您输入的内容不符合规则或者回复太频繁，请修改内容或者稍等片刻。',
                        position: 'right-top',
                        timeout: 5000
                    });
					return false
				} else {
					k = $(g, d).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function(a, b) {
						return a - b
					}).pop();
					if ($('.page-navigator .prev').length && l == "") {
						k = ''
					}
					if (l) {
						d = $('#comment-' + k, d).hide();
						if ($('#' + l).find(".comment-children").length <= 0) {
							$('#' + l).append("<div class='comment-children'><ol class='comment-list'><\/ol><\/div>")
						}
						if (k) $('#' + l + " .comment-children .comment-list").prepend(d);
						l = ''
					} else {
						d = $('#comment-' + k, d).hide();
						if (!$(g).length) $('#comments').prepend("<h3>已有 <span class='comment-num'>0<\/span> 条评论<\/h3><ol class='comment-list'><\/ol>");
						$(g).prepend(d)
					}
					$('#comment-' + k).fadeIn();
					var f;
					$(h).length ? (f = parseInt($(h).text().match(/\d+/)), $(h).html($(h).html().replace(f, f + 1))) : 0;
					TypechoComment.cancelReply();
					$(j).val('');
					$(i + ', #cancel-comment-reply-link').unbind('click');
					c();
					mdui.snackbar({
                        message: '评论已发送。',
                        position: 'right-top',
                        timeout: 5000
                    });
					if (k) {
						$body.animate({
							scrollTop: $('#comment-' + k).offset().top - 50
						},
						300)
					} else {
						$body.animate({
							scrollTop: $('#comments').offset().top - 50
						},
						300)
					}
				}
			}
		});
		return false
	});
	function c() {
		$(i).click(function() {
			l = $(this).parent().parent().parent().attr("id");
			$(j).focus()
		});
		$('#cancel-comment-reply-link').click(function() {
			l = ''
		})
	}
}
ac();
var protoken = '<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl('Token'); ?>'.replace('Token', "");
function ap() {
	$('.protected .post-title a, .protected .more a').click(function() {
		var a = $(this).parent().parent();
		a.find('.word').text("请输入密码访问").css('color', 'red').Shake(2, 10);
		a.find(':password').focus();
		return false
	});
	$('.protected form').submit(function() {
		ap_btn = $(this);
		ap_m = ap_btn.parent().find('.more a');
		ap_n = ap_btn.find('.word');
		$(ap_m).addClass('loading').text("请稍等"); 
		<?php if (!$this->options->AjaxLoad) : ?>
		apt(); 
		<?php else: ?>
		aps(); 
		<?php endif; ?>
		return false
	})
}
ap(); 
<?php if (!$this->options->AjaxLoad) : ?>
function apt() {
	var b = $('.protected .post-title a').attr("href");
	if ($('h1.post-title').length) {
		aps()
	} else {
		$.ajax({
			url: window.location.href,
			success: function(d) {
				protoken = $('.protected form[action^="' + b + '"]', d).attr("action").replace(b, "");
				if (protoken) {
					aps()
				} else {
					$(ap_m).removeAttr("class").text("- 阅读全文 -");
					mdui.snackbar({
                        message: '提交失败，请检查网络并重试或者联系管理员。',
                        position: 'right-top',
                        timeout: 3000
                    });
					ap_n.text("提交失败，请检查网络并重试或者联系管理员。").css('color', 'red').Shake(2, 10);
					return false
				}
			}
		})
	}
} <?php endif; ?>
function aps() {
	var c = ap_btn.parent().parent().find('.post-title a').attr("href");
	$.ajax({
		url: c + protoken,
		type: 'post',
		data: ap_btn.serializeArray(),
		error: function() {
			$(ap_m).removeAttr("class").text("- 阅读全文 -");
			mdui.snackbar({
                message: '提交失败，请检查网络并重试或者联系管理员。',
                position: 'right-top',
                timeout: 3000
            });
			ap_n.text("提交失败，请检查网络并重试或者联系管理员。").css('color', 'red').Shake(2, 10);
			return false
		},
		success: function(d) {
			if (!$('h1.post-title', d).length) {
				$(ap_m).removeAttr("class").text("- 阅读全文 -");
				mdui.snackbar({
                    message: '对不起,您输入的密码错误。',
                    position: 'right-top',
                    timeout: 3000
                });
				ap_n.text("对不起,您输入的密码错误。").css('color', 'red').Shake(2, 10);
				$(":password").val("");
				return false
			} else {
				$(ap_m).removeAttr("class").text("- 阅读全文 -");
				$('h1.post-title').length ? $.pjax.reload({
					container: '#main',
					fragment: '#main',
					timeout: 10000
				}) : $.pjax({
					url: c,
					container: '#main',
					fragment: '#main',
					timeout: 10000
				})
			}
		}
	})
}
</script>
<?php endif; if ($this->options->AjaxLoad): ?>
<script>
var isbool=true;
var autoloadtimes=0;
<?php if ($this->options->AjaxLoad == 'auto'): ?>
$(window).scroll(function(){
    <?php
        $autoloadtimes = $this->options->AjaxLoadTimes;
        if ($autoloadtimes=='0') {
            $leavrolzzzz="";
            /**我命名废！**/
        } else {
            $leavrolzzzz="&& autoloadtimes<".$autoloadtimes;
        }
    ?>
    if(isbool<?=$leavrolzzzz?>&&$('.ajaxload .next a').attr("href")&&($(this).scrollTop()+$(window).height()+20)>=$(document).height()){
        isbool=false;
        autoloadtimes++;
        console.log('Autoload '+autoloadtimes+' times');
        aln()
    }
});
<?php endif; ?>
function al() {
	$('.ajaxload li[class!="next"]').remove();
	$('.ajaxload .next a').click(function() {
		if (isbool) {
			aln()
		}
		return false
	})
}
al();
function aln() {
	var a = '.ajaxload .next a',
	b = $(a).attr("href");
	$(a).addClass('loading').text("正在加载");
	if (b) {
		$.ajax({
			url: b,
			error: function() {
				mdui.snackbar({
                    message: '请求失败，请检查网络并重试或者联系管理员。',
                    position: 'right-top',
                    timeout: 3000
                });
				$(a).removeAttr("class").text("查看更多");
				return false
			},
			success: function(d) {
				var c = $(d).find("#main .mdui-card"),
				e = $(d).find(a).attr("href");
				if (c) {
					$('.ajaxload').before(c)
				};
				$(a).removeAttr("class");
				if (e) {
					$(a).text("查看更多").attr("href", e)
				} else {
					$(a).remove();
					$('.ajaxload .next').text('没有更多文章了')
				}
				if ($('.protected', d).length) {
					$('.protected *').unbind();
					ap()
				}
				isbool = true;
				return false
			}
		})
	}
}
</script>
<?php endif; ?>
<?php $this->footer(); ?>
<?php if ($this->options->scrollTop || $this->options->HeadFixed || $this->options->SidebarFixed): ?>
<script>
    window.onscroll = function() {
    var a = document.documentElement.scrollTop || document.body.scrollTop; 
    <?php if ($this -> options -> scrollTop): ?>
    var b = document.getElementById("top");
    if (a >= 200) {
        b.classList.remove("mdui-fab-hide")
    } else {
        b.classList.add("mdui-fab-hide")
    }
    b.onclick = function totop() {
        var a = document.documentElement.scrollTop || document.body.scrollTop;
        if (a > 0) {
            requestAnimationFrame(totop);
            window.scrollTo(0, a - (a / 5))
        } else {
            cancelAnimationFrame(totop)
        }
    };
    <?php endif; if ($this -> options -> SidebarFixed): ?>
	if ($(window).width() > 1007){
		var e = document.getElementById("main"),
			f = document.getElementById("mdrDrawerR");
			f.style.marginTop = "-" + a + "px"
	}
    <?php endif; ?>
}
</script>
<?php endif; if ($this->options->MusicSet && $this->options->MusicUrl): ?>
<script>(function(){var a=document.getElementById("audio");var b=document.getElementById("music");var c=<?php Playlist() ?>;<?php if ($this->options->MusicVol): ?>var d=<?php $this->options->MusicVol(); ?>;if(d>=0&&d<=1){a.volume=d}<?php endif; ?>a.src=c.shift();a.addEventListener('play',g);a.addEventListener('pause',h);a.addEventListener('ended',f);a.addEventListener('error',f);a.addEventListener('canplay',j);function f(){if(!c.length){a.removeEventListener('play',g);a.removeEventListener('pause',h);a.removeEventListener('ended',f);a.removeEventListener('error',f);a.removeEventListener('canplay',j);b.style.display="none";mdui.snackbar({message: '本站的背景音乐好像有问题了，希望您可以通过留言等方式通知管理员，谢谢您的帮助。',position: 'right-top',timeout: 5000});}else{a.src=c.shift();a.play()}}function g(){b.setAttribute("class","play");a.addEventListener('timeupdate',k)}function h(){b.removeAttribute("class");a.removeEventListener('timeupdate',k)}function j(){c.push(a.src)}function k(){b.getElementsByTagName("i")[0].style.width=(a.currentTime/a.duration*100).toFixed(1)+"%"}b.onclick=function(){if(a.canPlayType('audio/mpeg')!=""||a.canPlayType('audio/ogg;codes="vorbis"')!=""||a.canPlayType('audio/mp4;codes="mp4a.40.5"')!=""){if(a.paused){if(a.error){f()}else{a.play()}}else{a.pause()}}else{mdui.snackbar({message: '对不起，您的浏览器不支持HTML5音频播放，请升级您的浏览器。',position: 'right-top',timeout: 5000});}};b.removeAttribute("class")})();</script>
<?php endif; if ($this->options->CustomContent): $this->options->CustomContent(); ?>

<?php endif; ?>
<script>
var cornertool=true;
function cl(){
    var a=document.getElementById("catalog-col"),
        b=document.getElementById("catalog"),
        c=document.getElementById("cornertool"),
        d;
    if(a&&!b){
        d=document.createElement("div");
        d.setAttribute("id","catalog");
        d.setAttribute("onclick","Catalogswith()");
        d.setAttribute("class","mdui-fab mdui-ripple mdui-fab-mini mdui-color-white");
        d.setAttribute("style","display:block;margin-top:8px;");
        d.innerHTML='<i class="mdui-icon material-icons">&#xe5d2;</i>';
        c.appendChild(d);
    }if(!a&&b){
        cornertool?c.removeChild(b):document.body.removeChild(c)
    }if(a&&b){
        b.className=a.className
    }
}
cl();
console.log("\n %c MDr By FlyingSky %c https://fsky7.com/ %c \n","color:#fff;background:#6cf;padding:5px 0;border: 1px solid #6cf;","color:#fff;background:#fff;padding:5px 0;border: 1px solid #6cf;","");
</script>
<?php if ($this->options->DarkMode): ?>
<?php 
    if ($this->options->DarkModeFD && $this->options->DarkModeDomain) {
        $DarkModeFD="domain=".$this->options->DarkModeDomain;
    } else {
        $DarkModeFD="";
    }
?>
<script>
    function onDarkMode() {
        $('body').addClass('mdui-theme-layout-dark');
        $('body').addClass('mdui-theme-accent-<?php $this->options->mdrAccentD() ?>');
        $('body').removeClass('mdui-theme-accent-<?php $this->options->mdrAccent() ?>');
        $('.mdui-appbar').css('background-color','#212121');
    }
    function offDarkMode() {
        $('body').removeClass('mdui-theme-layout-dark');
        $('body').addClass('mdui-theme-accent-<?php $this->options->mdrAccent() ?>');
        $('body').removeClass('mdui-theme-accent-<?php $this->options->mdrAccentD() ?>');
        $('.mdui-appbar').css('background-color','#ffffff');
    }
</script>
<script>
function switchDarkMode(){
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if (night == '0'){
        onDarkMode();
        document.cookie = "dark=1;path=/;<?=$DarkModeFD?>";
        console.log('Dark mode on 1');
        mdui.snackbar({message: '已开启 Dark Mode ，早 6 点之前保持开启。',position: 'right-top',timeout: 1000});
    }else{
       offDarkMode();
        document.cookie = "dark=0;path=/;<?=$DarkModeFD?>";
        console.log('Dark mode off 1');
        mdui.snackbar({message: '已关闭 Dark Mode ',position: 'right-top',timeout: 1000});
    }
}
(function(){
    if(document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") === ''){
        if(new Date().getHours() > 22 || new Date().getHours() < 6){
            onDarkMode();
            document.cookie = "dark=1;path=/;<?=$DarkModeFD?>";
            console.log('Dark mode on 2');
        }else{
            offDarkMode();
            document.cookie = "dark=0;path=/;<?=$DarkModeFD?>";
            console.log('Dark mode off 2');
        }
    }else{
        var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
        if(dark == '0'){
            offDarkMode();
        }else if(dark == '1'){
            onDarkMode();
        }
    }
})();
document.addEventListener('visibilitychange', function () {
    var dark = document.cookie.replace(/(?:(?:^|.*;\s*)dark\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if(dark == '0'){
        offDarkMode();
    }else if(dark == '1'){
        onDarkMode();
    }
});
</script>
<?php endif; ?>
</body>
</html><?php if ($this->options->compressHtml): $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); endif; ?>