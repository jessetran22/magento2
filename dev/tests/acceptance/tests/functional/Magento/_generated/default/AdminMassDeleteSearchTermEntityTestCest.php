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
 * @Title("MC-14767: Admin mass delete search term entity test")
 * @Description("Admin should be able to Mass Delete Search Term Entity Test<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/AdminMassDeleteSearchTermEntityTest.xml<br>")
 * @TestCaseId("MC-14767")
 * @group searchFrontend
 * @group mtf_migrated
 */
class AdminMassDeleteSearchTermEntityTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create three search term");
		$I->createEntity("createFirstSearchTerm", "hook", "SearchTerm", [], []); // stepKey: createFirstSearchTerm
		$I->createEntity("createSecondSearchTerm", "hook", "SearchTerm", [], []); // stepKey: createSecondSearchTerm
		$I->createEntity("createThirdSearchTerm", "hook", "SearchTerm", [], []); // stepKey: createThirdSearchTerm
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Search"})
	 * @Stories({"Delete search term"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassDeleteSearchTermEntityTest(AcceptanceTester $I)
	{
		$I->comment("Go to the catalog search term page");
		$I->comment("Entering Action Group [openAdminCatalogSearchTermIndexPage] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchTermIndexPageOpenAdminCatalogSearchTermIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAdminCatalogSearchTermIndexPage
		$I->comment("Exiting Action Group [openAdminCatalogSearchTermIndexPage] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->comment("Select all created below search terms");
		$I->comment("Entering Action Group [filterByFirstSearchQuery] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonFilterByFirstSearchQuery
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonFilterByFirstSearchQueryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetFilterFilterByFirstSearchQuery
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createFirstSearchTerm', 'query_text', 'test')); // stepKey: fillSearchQueryFilterByFirstSearchQuery
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonFilterByFirstSearchQuery
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonFilterByFirstSearchQueryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadFilterByFirstSearchQuery
		$I->checkOption("//*[normalize-space()='" . $I->retrieveEntityField('createFirstSearchTerm', 'query_text', 'test') . "']/preceding-sibling::td//input[@name='search']"); // stepKey: checkCheckBoxFilterByFirstSearchQuery
		$I->waitForPageLoad(30); // stepKey: checkCheckBoxFilterByFirstSearchQueryWaitForPageLoad
		$I->comment("Exiting Action Group [filterByFirstSearchQuery] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->comment("Entering Action Group [filterBySecondSearchQuery] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonFilterBySecondSearchQuery
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonFilterBySecondSearchQueryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetFilterFilterBySecondSearchQuery
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createSecondSearchTerm', 'query_text', 'test')); // stepKey: fillSearchQueryFilterBySecondSearchQuery
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonFilterBySecondSearchQuery
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonFilterBySecondSearchQueryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadFilterBySecondSearchQuery
		$I->checkOption("//*[normalize-space()='" . $I->retrieveEntityField('createSecondSearchTerm', 'query_text', 'test') . "']/preceding-sibling::td//input[@name='search']"); // stepKey: checkCheckBoxFilterBySecondSearchQuery
		$I->waitForPageLoad(30); // stepKey: checkCheckBoxFilterBySecondSearchQueryWaitForPageLoad
		$I->comment("Exiting Action Group [filterBySecondSearchQuery] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->comment("Entering Action Group [filterByThirdSearchQuery] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonFilterByThirdSearchQuery
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonFilterByThirdSearchQueryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetFilterFilterByThirdSearchQuery
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createThirdSearchTerm', 'query_text', 'test')); // stepKey: fillSearchQueryFilterByThirdSearchQuery
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonFilterByThirdSearchQuery
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonFilterByThirdSearchQueryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadFilterByThirdSearchQuery
		$I->checkOption("//*[normalize-space()='" . $I->retrieveEntityField('createThirdSearchTerm', 'query_text', 'test') . "']/preceding-sibling::td//input[@name='search']"); // stepKey: checkCheckBoxFilterByThirdSearchQuery
		$I->waitForPageLoad(30); // stepKey: checkCheckBoxFilterByThirdSearchQueryWaitForPageLoad
		$I->comment("Exiting Action Group [filterByThirdSearchQuery] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->comment("Delete created below search terms");
		$I->comment("Entering Action Group [deleteSearchTerms] AdminDeleteSearchTermActionGroup");
		$I->selectOption("//div[@class='admin__grid-massaction-form']//select[@id='search_term_grid_massaction-select']", "delete"); // stepKey: selectDeleteOptionDeleteSearchTerms
		$I->click("//button[@class='action-default scalable']/span"); // stepKey: clickSubmitButtonDeleteSearchTerms
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonDeleteSearchTermsWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']/span"); // stepKey: clickOkButtonDeleteSearchTerms
		$I->waitForPageLoad(30); // stepKey: clickOkButtonDeleteSearchTermsWaitForPageLoad
		$I->waitForElementVisible("//div[@class='message message-success success']/div[@data-ui-id='messages-message-success']", 30); // stepKey: waitForSuccessMessageDeleteSearchTerms
		$I->comment("Exiting Action Group [deleteSearchTerms] AdminDeleteSearchTermActionGroup");
		$I->comment("Assert search terms are absent on the search term page");
		$I->comment("Entering Action Group [assertFirstSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchIndexPageAssertFirstSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadAssertFirstSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonAssertFirstSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonAssertFirstSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertFirstSearchTermNotInGrid
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createFirstSearchTerm', 'query_text', 'test')); // stepKey: fillSearchQueryAssertFirstSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonAssertFirstSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertFirstSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultToLoadAssertFirstSearchTermNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeEmptyRecordMessageAssertFirstSearchTermNotInGrid
		$I->comment("Exiting Action Group [assertFirstSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->comment("Entering Action Group [assertSecondSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchIndexPageAssertSecondSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadAssertSecondSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonAssertSecondSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonAssertSecondSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertSecondSearchTermNotInGrid
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createSecondSearchTerm', 'query_text', 'test')); // stepKey: fillSearchQueryAssertSecondSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonAssertSecondSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertSecondSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultToLoadAssertSecondSearchTermNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeEmptyRecordMessageAssertSecondSearchTermNotInGrid
		$I->comment("Exiting Action Group [assertSecondSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->comment("Entering Action Group [assertThirdSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchIndexPageAssertThirdSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadAssertThirdSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonAssertThirdSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonAssertThirdSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertThirdSearchTermNotInGrid
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createThirdSearchTerm', 'query_text', 'test')); // stepKey: fillSearchQueryAssertThirdSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonAssertThirdSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertThirdSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultToLoadAssertThirdSearchTermNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeEmptyRecordMessageAssertThirdSearchTermNotInGrid
		$I->comment("Exiting Action Group [assertThirdSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->comment("Go to storefront page");
		$I->comment("Entering Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPage
		$I->comment("Exiting Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Verify search term deletion on storefront");
		$I->comment("Entering Action Group [quickSearchForFirstSearchTerm] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createFirstSearchTerm', 'query_text', 'test')]); // stepKey: fillQuickSearchQuickSearchForFirstSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForFirstSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForFirstSearchTerm
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createFirstSearchTerm', 'query_text', 'test') . "'"); // stepKey: assertQuickSearchTitleQuickSearchForFirstSearchTerm
		$I->see("Search results for: '" . $I->retrieveEntityField('createFirstSearchTerm', 'query_text', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForFirstSearchTerm
		$I->comment("Exiting Action Group [quickSearchForFirstSearchTerm] StorefrontCheckQuickSearchActionGroup");
		$I->comment("Entering Action Group [checkEmptyForFirstSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptyForFirstSearchTerm
		$I->comment("Exiting Action Group [checkEmptyForFirstSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->comment("Entering Action Group [quickSearchForSecondSearchTerm] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createSecondSearchTerm', 'query_text', 'test')]); // stepKey: fillQuickSearchQuickSearchForSecondSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForSecondSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForSecondSearchTerm
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createSecondSearchTerm', 'query_text', 'test') . "'"); // stepKey: assertQuickSearchTitleQuickSearchForSecondSearchTerm
		$I->see("Search results for: '" . $I->retrieveEntityField('createSecondSearchTerm', 'query_text', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForSecondSearchTerm
		$I->comment("Exiting Action Group [quickSearchForSecondSearchTerm] StorefrontCheckQuickSearchActionGroup");
		$I->comment("Entering Action Group [checkEmptyForSecondSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptyForSecondSearchTerm
		$I->comment("Exiting Action Group [checkEmptyForSecondSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->comment("Entering Action Group [quickSearchForThirdSearchTerm] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createThirdSearchTerm', 'query_text', 'test')]); // stepKey: fillQuickSearchQuickSearchForThirdSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForThirdSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForThirdSearchTerm
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createThirdSearchTerm', 'query_text', 'test') . "'"); // stepKey: assertQuickSearchTitleQuickSearchForThirdSearchTerm
		$I->see("Search results for: '" . $I->retrieveEntityField('createThirdSearchTerm', 'query_text', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForThirdSearchTerm
		$I->comment("Exiting Action Group [quickSearchForThirdSearchTerm] StorefrontCheckQuickSearchActionGroup");
		$I->comment("Entering Action Group [checkEmptyForThirdSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptyForThirdSearchTerm
		$I->comment("Exiting Action Group [checkEmptyForThirdSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
	}
}
