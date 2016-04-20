// MAM - Michael, Andrea, Markus
// Function to filter portfolio items

function toggleVisiblePortfolioProjects(portfolioCategory) {
	$("#portfolioSelected").attr("id", "portfolioNotSelected");
    console.log("portCategory.name = " + $(portfolioCategory).attr("name"));
	$(portfolioCategory).attr("id","portfolioSelected");
	$(".portfolioFigure").each(function() {
		$(this).css("display", "inline-block");
	});
	if($(portfolioCategory).attr("name") != "ALL") {
		$(".portfolioFigure[name!='"+ $(portfolioCategory).attr("name") +"']").each(function() {
			$(this).css("display", "none");
		});
	}
}
