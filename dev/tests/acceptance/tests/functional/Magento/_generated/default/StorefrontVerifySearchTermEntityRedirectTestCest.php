<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("[NO TESTCASEID]: Create Search Term Entity With Redirect. Check How Redirect is Working on Storefront")
 * @Description("Storefront search by created search term with redirect. Verifying if created redirect is working<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/StorefrontVerifySearchTermEntityRedirectTest.xml<br>")
 */
class StorefrontVerifySearchTermEntityRedirectTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login As Admin User");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Navigate To Marketing Search Terms Grid");
		$I->comment("Entering Action Group [navigateToSearchTermPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToSearchTermPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToSearchTermPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToSearchTermPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-search-search-terms']"); // stepKey: clickOnSubmenuItemNavigateToSearchTermPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToSearchTermPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToSearchTermPage] AdminNavigateMenuActionGroup");
		$I->comment("Create Custom Search Term With Redirect");
		$I->comment("Entering Action Group [createSearchTerm] AdminCreateNewSearchTermEntityActionGroup");
		$I->click(".page-actions-buttons .add"); // stepKey: clickAddNewButtonCreateSearchTerm
		$I->fillField(".admin__field-control.control #query_text", "Query text" . msq("SearchTerm")); // stepKey: fillSearchQueryFieldCreateSearchTerm
		$I->selectOption(".admin__field-control.control #store_id", "1"); // stepKey: storeSelectCreateSearchTerm
		$I->fillField(".admin__field-control.control #redirect", "http://example.com/" . msq("SearchTerm")); // stepKey: fillRedirectUrlCreateSearchTerm
		$I->click(".page-actions-buttons .save"); // stepKey: saveSearchTermCreateSearchTerm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCreateSearchTerm
		$I->comment("Exiting Action Group [createSearchTerm] AdminCreateNewSearchTermEntityActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToSearchTermPage] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchTermIndexPageNavigateToSearchTermPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToSearchTermPage
		$I->comment("Exiting Action Group [navigateToSearchTermPage] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->comment("Entering Action Group [findCreatedTerm] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonFindCreatedTerm
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonFindCreatedTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetFilterFindCreatedTerm
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", "Query text" . msq("SearchTerm")); // stepKey: fillSearchQueryFindCreatedTerm
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonFindCreatedTerm
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonFindCreatedTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadFindCreatedTerm
		$I->checkOption("//*[normalize-space()='Query text" . msq("SearchTerm") . "']/preceding-sibling::td//input[@name='search']"); // stepKey: checkCheckBoxFindCreatedTerm
		$I->waitForPageLoad(30); // stepKey: checkCheckBoxFindCreatedTermWaitForPageLoad
		$I->comment("Exiting Action Group [findCreatedTerm] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->comment("Entering Action Group [deleteCreatedSearchTerm] AdminDeleteSearchTermActionGroup");
		$I->selectOption("//div[@class='admin__grid-massaction-form']//select[@id='search_term_grid_massaction-select']", "delete"); // stepKey: selectDeleteOptionDeleteCreatedSearchTerm
		$I->click("//button[@class='action-default scalable']/span"); // stepKey: clickSubmitButtonDeleteCreatedSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonDeleteCreatedSearchTermWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']/span"); // stepKey: clickOkButtonDeleteCreatedSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickOkButtonDeleteCreatedSearchTermWaitForPageLoad
		$I->waitForElementVisible("//div[@class='message message-success success']/div[@data-ui-id='messages-message-success']", 30); // stepKey: waitForSuccessMessageDeleteCreatedSearchTerm
		$I->comment("Exiting Action Group [deleteCreatedSearchTerm] AdminDeleteSearchTermActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"Search Term Redirect"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Search"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifySearchTermEntityRedirectTest(AcceptanceTester $I)
	{
		$I->comment("TEST BODY");
		$I->comment("Navigate To StoreFront");
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Fill in Search Field, Submit Search Request");
		$I->comment("Entering Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->fillField("#search", "Query text" . msq("SearchTerm")); // stepKey: fillSearchFieldSearchByCreatedTerm
		$I->waitForElementVisible("button.action.search", 30); // stepKey: waitForSubmitButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: waitForSubmitButtonSearchByCreatedTermWaitForPageLoad
		$I->click("button.action.search"); // stepKey: clickSearchButtonSearchByCreatedTerm
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonSearchByCreatedTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultsSearchByCreatedTerm
		$I->comment("Exiting Action Group [searchByCreatedTerm] StoreFrontQuickSearchActionGroup");
		$I->comment("Assert Current Url");
		$I->seeCurrentUrlEquals("http://example.com/" . msq("SearchTerm")); // stepKey: checkUrl
	}
}
