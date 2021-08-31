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
 * @Title("MC-13988: Delete Search Term and Verify Storefront")
 * @Description("Test log in to SearchTerm and DeleteSearchTerm<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/AdminDeleteSearchTermTest.xml<br>")
 * @TestCaseId("MC-13988")
 * @group CatalogSearch
 * @group mtf_migrated
 */
class AdminDeleteSearchTermTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("initialCategoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: initialCategoryEntity
		$I->createEntity("simpleProduct", "hook", "SimpleProduct", ["initialCategoryEntity"], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Search terms"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteSearchTermTest(AcceptanceTester $I)
	{
		$I->comment("Add new search term");
		$I->comment("Entering Action Group [addNewSearchTerm] AssertSearchTermSaveSuccessMessageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openAdminCatalogSearchTermIndexPageAddNewSearchTerm
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadAddNewSearchTerm
		$I->click("//div[@class='page-actions-buttons']/button[@id='add']"); // stepKey: clickAddNewSearchTermButtonAddNewSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickAddNewSearchTermButtonAddNewSearchTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermNewPageLoadAddNewSearchTerm
		$I->fillField("#query_text", "Query text" . msq("SimpleTerm")); // stepKey: fillSearchQueryTextBoxAddNewSearchTerm
		$I->selectOption("#store_id", "Default Store View"); // stepKey: selectStoreValueAddNewSearchTerm
		$I->fillField("//div[@class='admin__field-control control']/input[@id='redirect']", "http://example.com/" . msq("SimpleTerm")); // stepKey: fillRedirectUrlAddNewSearchTerm
		$I->selectOption("//select[@name='display_in_terms']", "No"); // stepKey: selectDisplayInSuggestedTermAddNewSearchTerm
		$I->click("//button[@id='save']/span[@class='ui-button-text']"); // stepKey: clickSaveSearchButtonAddNewSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickSaveSearchButtonAddNewSearchTermWaitForPageLoad
		$I->see("You saved the search term.", "//div[@class='message message-success success']/div[@data-ui-id='messages-message-success']"); // stepKey: seeSaveSuccessMessageAddNewSearchTerm
		$I->comment("Exiting Action Group [addNewSearchTerm] AssertSearchTermSaveSuccessMessageActionGroup");
		$I->comment("Search and delete search term and AssertSearchTermSuccessDeleteMessage");
		$I->comment("Entering Action Group [deleteSearchTerm] AssertSearchTermSuccessDeleteMessageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchIndexPageDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadDeleteSearchTerm
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonDeleteSearchTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteSearchTerm
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", "Query text" . msq("SimpleTerm")); // stepKey: fillSearchQueryDeleteSearchTerm
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSearchTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadDeleteSearchTerm
		$I->click("//tbody/tr['1']//input[@name='search']"); // stepKey: checkFirstRowDeleteSearchTerm
		$I->selectOption("//div[@class='admin__grid-massaction-form']//select[@id='search_term_grid_massaction-select']", "delete"); // stepKey: selectDeleteOptionDeleteSearchTerm
		$I->click("//button[@class='action-default scalable']/span"); // stepKey: clickSubmitButtonDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonDeleteSearchTermWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']/span"); // stepKey: clickOkButtonDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickOkButtonDeleteSearchTermWaitForPageLoad
		$I->see("Total of 1 record(s) were deleted.", "//div[@class='message message-success success']/div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageDeleteSearchTerm
		$I->comment("Exiting Action Group [deleteSearchTerm] AssertSearchTermSuccessDeleteMessageActionGroup");
		$I->comment("Verify deleted search term in grid and AssertSearchTermNotInGrid");
		$I->comment("Entering Action Group [verifyDeletedSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchIndexPageVerifyDeletedSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadVerifyDeletedSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonVerifyDeletedSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonVerifyDeletedSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadVerifyDeletedSearchTermNotInGrid
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", "Query text" . msq("SimpleTerm")); // stepKey: fillSearchQueryVerifyDeletedSearchTermNotInGrid
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonVerifyDeletedSearchTermNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonVerifyDeletedSearchTermNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultToLoadVerifyDeletedSearchTermNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeEmptyRecordMessageVerifyDeletedSearchTermNotInGrid
		$I->comment("Exiting Action Group [verifyDeletedSearchTermNotInGrid] AssertSearchTermNotInGridActionGroup");
		$I->comment("Go to storefront and Verify AssertSearchTermNotOnFrontend");
		$I->comment("Entering Action Group [verifySearchTermNotOnFrontend] AssertSearchTermNotOnFrontendActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToMagentoStorefrontPageVerifySearchTermNotOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoadVerifySearchTermNotOnFrontend
		$I->fillField("#search", "Query text" . msq("SimpleTerm")); // stepKey: fillSearchQueryVerifySearchTermNotOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForSearchTextBoxVerifySearchTermNotOnFrontend
		$I->click("button[class='action search']"); // stepKey: clickSearchTextBoxButtonVerifySearchTermNotOnFrontend
		$I->waitForPageLoad(30); // stepKey: clickSearchTextBoxButtonVerifySearchTermNotOnFrontendWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchVerifySearchTermNotOnFrontend
		$I->see("Your search returned no results.", "div.message.notice div"); // stepKey: seeAssertSearchTermNotOnFrontendNoticeMessageVerifySearchTermNotOnFrontend
		$I->comment("Exiting Action Group [verifySearchTermNotOnFrontend] AssertSearchTermNotOnFrontendActionGroup");
	}
}
