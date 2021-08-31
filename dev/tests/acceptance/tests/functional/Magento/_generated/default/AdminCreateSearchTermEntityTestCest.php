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
 * @Title("MC-13989: Create search term test")
 * @Description("Admin should be able to create search term<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/AdminCreateSearchTermEntityTest.xml<br>")
 * @TestCaseId("MC-13989")
 * @group CatalogSearch
 * @group mtf_migrated
 */
class AdminCreateSearchTermEntityTestCest
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
		$I->comment("Create simple product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created search term");
		$I->comment("Entering Action Group [deleteSearchTerm] AssertSearchTermSuccessDeleteMessageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchIndexPageDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadDeleteSearchTerm
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonDeleteSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonDeleteSearchTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteSearchTerm
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: fillSearchQueryDeleteSearchTerm
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
		$I->comment("Delete created product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Search terms"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateSearchTermEntityTest(AcceptanceTester $I)
	{
		$I->comment("Go to the search terms page and create new search term");
		$I->comment("Entering Action Group [createNewSearchTerm] AssertSearchTermSaveSuccessMessageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openAdminCatalogSearchTermIndexPageCreateNewSearchTerm
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermIndexPageLoadCreateNewSearchTerm
		$I->click("//div[@class='page-actions-buttons']/button[@id='add']"); // stepKey: clickAddNewSearchTermButtonCreateNewSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickAddNewSearchTermButtonCreateNewSearchTermWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogSearchTermNewPageLoadCreateNewSearchTerm
		$I->fillField("#query_text", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSearchQueryTextBoxCreateNewSearchTerm
		$I->selectOption("#store_id", "Default Store View"); // stepKey: selectStoreValueCreateNewSearchTerm
		$I->fillField("//div[@class='admin__field-control control']/input[@id='redirect']", "http://example.com/" . msq("SimpleTerm")); // stepKey: fillRedirectUrlCreateNewSearchTerm
		$I->selectOption("//select[@name='display_in_terms']", "No"); // stepKey: selectDisplayInSuggestedTermCreateNewSearchTerm
		$I->click("//button[@id='save']/span[@class='ui-button-text']"); // stepKey: clickSaveSearchButtonCreateNewSearchTerm
		$I->waitForPageLoad(30); // stepKey: clickSaveSearchButtonCreateNewSearchTermWaitForPageLoad
		$I->see("You saved the search term.", "//div[@class='message message-success success']/div[@data-ui-id='messages-message-success']"); // stepKey: seeSaveSuccessMessageCreateNewSearchTerm
		$I->comment("Exiting Action Group [createNewSearchTerm] AssertSearchTermSaveSuccessMessageActionGroup");
		$I->comment("Go to storefront");
		$I->comment("Entering Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStorefrontPage
		$I->comment("Exiting Action Group [amOnStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Assert created search term on storefront");
		$I->comment("Entering Action Group [assertCreatedSearchTermOnFrontend] AssertSearchTermOnFrontendActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSearchQueryAssertCreatedSearchTermOnFrontend
		$I->waitForPageLoad(30); // stepKey: waitForFillFieldAssertCreatedSearchTermOnFrontend
		$I->click("button[class='action search']"); // stepKey: clickSearchTextBoxButtonAssertCreatedSearchTermOnFrontend
		$I->waitForPageLoad(30); // stepKey: clickSearchTextBoxButtonAssertCreatedSearchTermOnFrontendWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchAssertCreatedSearchTermOnFrontend
		$I->seeInCurrentUrl("http://example.com/" . msq("SimpleTerm")); // stepKey: checkUrlAssertCreatedSearchTermOnFrontend
		$I->comment("Exiting Action Group [assertCreatedSearchTermOnFrontend] AssertSearchTermOnFrontendActionGroup");
	}
}
