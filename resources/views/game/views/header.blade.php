<style>

</style>

<header class="header z-3 sticky">
	<nav class="navbar navbar-expand-lg py-0">
		<div class="modal-background" id="modalBackground"></div>
		<div class="side-header" style="display: block;"></div>
		<div class="container-fluid">
			<a class="navbar-brand logo-center site-logo" href="{{ $localePrefix ?: '/' }}">
				<img src="/images/site-logo.webp" alt="Marios.games Logo" width="190" height="55">
			</a>
			<div class="search-container">
				<div class="modal-background" id="modalBackground"></div>
				<div class="search-box">
					<form method="get" action="{{ $localePrefix }}/search" onsubmit="return validateSearchForm();">
						<div class="input-container">
							<input type="text" name="name" aria-label="Name" id="name" autocomplete="off" value=""
								placeholder="{{ __('messages.search_placeholder') }}" oninput="toggleClearButton()"
								onfocus="showTransparentBackground()">
							<button aria-label="search" type="submit">
					<img src="/images/search-icon.svg?v=1" width="20" height="20" alt="search icon ">
							</button>
							<div id="clearButton" class="clear-button" onclick="clearSearchAndCloseDiv()">
								<span class="close-button">x</span>
							</div>
						</div>
					</form>
					<div id="display"></div>
				</div>
			</div>
			<button class="btn btn-secondary p-0 rounded-5 me-md-3 order-md-0 me-2 mob-search-btn"
				data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
				<img src="/images/search-icon.svg?v=1" width="25" height="25" alt="search icon ">
			</button>
			<button class="btn btn-secondary p-0 rounded-5 me-md-3 order-md-0" data-bs-toggle="offcanvas"
				data-bs-target="#offcanvasmenu" aria-controls="offcanvasmenu">
				<img src="/images/nav-toggle-icon-close.svg?v=1" width="40" height="40"
					alt="Left Sidebar Menu Open Icon" class="">
			</button>
		</div>
	</nav>
</header>
<script>

	document.addEventListener("DOMContentLoaded", function () {
		var e = document.getElementById("langue-options-container")
			, t = document.getElementById("langue-arrow")
			, n = document.getElementById("langue-selected");
		if (!n) {
			return;
		}
		n.addEventListener("click", function () {
			"block" === e.style.display ? (e.style.display = "none",
				t.classList.remove("down"),
				t.classList.add("up")) : (e.style.display = "block",
					t.classList.remove("up"),
					t.classList.add("down"))
		});
		document.querySelectorAll(".langue-option").forEach(function (n) {
			n.addEventListener("click", function () {
				e.style.display = "none",
					t.classList.remove("down"),
					t.classList.add("up"),
					window.open(this.getAttribute("data-url"), "_blank")
			})
		})
	});
	$(document).ready(function () {
		$(".modal-link").on("click", function (o) {
			o.preventDefault();
			var t = $(this).data("file");
			$("#modalBody").load(t, function (o, t, n) {
				"error" == t && $("#modalBody").html("Sorry but there was an error: " + n.status + " " + n.statusText)
			}),
				$("#opContent").fadeIn(),
				$("body").addClass("no-scroll")
		}),
			$(".close, #opContent").click(function (o) {
				o.target == this && ($("#opContent").fadeOut(),
					$("body").removeClass("no-scroll"))
			})
	});

	function toggleClearButton() {
		var e = document.getElementById("name").value.trim()
			, t = document.getElementById("clearButton")
			, n = document.getElementById("modalBackground");
		e.length >= 2 ? (t.style.display = "inline-block",
			n.style.display = "block") : (t.style.display = "none",
				n.style.display = "none")
	}
	function clearSearchText() {
		document.getElementById("name").value = "",
			document.getElementById("clearButton").style.display = "none",
			document.getElementById("modalBackground").style.display = "none"
	}
	function clearSearchAndCloseDiv() {
		clearSearchText(),
			document.getElementById("display").style.display = "none"
	}
	function showTransparentBackground() {
		var e = document.getElementById("name").value.trim()
			, t = document.getElementById("modalBackground");
		e.length >= 2 ? t.style.display = "block" : t.style.display = "none"
	}
	document.getElementById("modalBackground").addEventListener("click", function (e) {
		e.target === this && clearSearchAndCloseDiv()
	});
	function validateSearchForm() {
		const e = document.getElementById("name").value.trim();
		return !(e.length < 3)
	}
	function fill(e) {
		$("#name").val(e),
			$("#display").hide()
	}
	$(document).ready(function () {
		$("#name").keyup(function () {
			var e = $("#name").val();
			"" == e ? $("#display").html("") : $.ajax({
				type: "POST",
				url: "/api/ajax",
				data: "name=" + e,
				success: function (e) {
					$("#display").html(e).show()
				}
			})
		})
	});


	$(document).ready(function () {
		$(".modal-link").on("click", function (o) {
			o.preventDefault();
			var t = $(this).data("file");
			$("#modalBody").load(t, function (o, t, n) {
				"error" == t && $("#modalBody").html("Sorry but there was an error: " + n.status + " " + n.statusText)
			}),
				$("#opContent").fadeIn(),
				$("body").addClass("no-scroll")
		}),
			$(".close, #opContent").click(function (o) {
				o.target == this && ($("#opContent").fadeOut(),
					$("body").removeClass("no-scroll"))
			})
	});

	let offset = 0
		, limit = 3
		, isLoading = !1
		, hasMoreCategories = !0;
	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll(".game").forEach(function (e) {
			var n, t = e.querySelector("img"), r = e.querySelector("video");
			if (!t || !r) {
				return
			}
			function o() {
				t.style.display = "none",
					r.style.display = "block",
					void 0 !== (n = r.play()) && n.catch(function (e) {
						console.error("ERROR:", e)
					}),
					r.removeEventListener("canplay", o)
			}
			e.addEventListener("mouseenter", function () {
				r && (r.load(),
					r.addEventListener("canplay", o))
			}),
				e.addEventListener("mouseleave", function () {
					void 0 !== n ? n.then(function () {
						r && (r.pause(),
							r.currentTime = 0)
					}).catch(function (e) {
						console.error("ERROR", e)
					}) : r && (r.pause(),
						r.currentTime = 0),
						r && (r.style.display = "none"),
						t && (t.style.display = "block"),
						r && r.removeEventListener("canplay", o)
				})
		})
	});
	document.querySelectorAll(".game").forEach(function (e) {
		e.addEventListener("mouseenter", function () {
			let e = this.previousElementSibling;
			e && e.classList.contains("ribbon_box") && [".ribbon_e", ".ribbon_u", ".ribbon_t", ".ribbon_h"].forEach(function (n) {
				let i = e.querySelector(n);
				i && i.classList.add("hidden2")
			})
		}),
			e.addEventListener("mouseleave", function () {
				let e = this.previousElementSibling;
				e && e.classList.contains("ribbon_box") && [".ribbon_e", ".ribbon_u", ".ribbon_t", ".ribbon_h"].forEach(function (n) {
					let i = e.querySelector(n);
					i && i.classList.remove("hidden2")
				})
			})
	});

	//============================


	function initializeLazyLoading(e) {
		let t = [].slice.call(e.getElementsByClassName("lazyload"));
		"IntersectionObserver" in window ? (() => {
			let e = new IntersectionObserver(function (t) {
				t.forEach(function (t) {
					if (t.isIntersecting) {
						let n = t.target;
						n.src = n.dataset.src,
							n.classList.remove("lazyload"),
							e.unobserve(n)
					}
				})
			}
			);
			t.forEach(function (t) {
				e.observe(t)
			})
		}
		)() : t.forEach(function (e) {
			e.src = e.dataset.src,
				e.classList.remove("lazy")
		})
	}


</script>

<script>
(function() {
  const path = window.location.pathname;
  const base = "https://marios.games";

  if (path === "/") return;

  const segments = path.split("/").filter(Boolean);

  let items = [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": base + "/"
    }
  ];

  if (segments[0] === "c") {
    const categoryName = segments[1].replace(/-/g, " ");
    items.push({
      "@type": "ListItem",
      "position": 2,
      "name": categoryName.charAt(0).toUpperCase() + categoryName.slice(1) + " Games",
      "item": base + "/c/" + segments[1] + "/"
    });
  }

  if (segments[0] === "g") {
    const gameName = document.querySelector("h1")?.innerText || document.title;

    items.push({
      "@type": "ListItem",
      "position": 2,
      "name": "Mario Games",
      "item": base + "/c/super-mario/"
    });

    items.push({
      "@type": "ListItem",
      "position": 3,
      "name": gameName,
      "item": window.location.href
    });
  }

  const schema = {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "@id": window.location.href + "#breadcrumb",
    "itemListElement": items
  };

  const script = document.createElement("script");
  script.type = "application/ld+json";
  script.text = JSON.stringify(schema);

  document.head.appendChild(script);
})();
</script>
