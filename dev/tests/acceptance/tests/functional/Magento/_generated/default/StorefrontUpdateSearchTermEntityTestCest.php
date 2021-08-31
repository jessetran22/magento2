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
 * @Title("MC-13987: Update Storefront Search Results")
 * @Description("You should see the updated Search Term on the Storefront via the Admin.<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontUpdateSearchTermEntityTest.xml<br>")
 * @TestCaseId("MC-13987")
 * @group search
 * @group mtf_migrated
 */
class StorefrontUpdateSearchTermEntityTestCest
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
		$I->createEntity("createCategory1", "hook", "_defaultCategory", [], []); // stepKey: createCategory1
		$I->createEntity("createProduct1", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createProduct1
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [amOnStorefrontPage1] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStorefrontPage1
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStorefrontPage1
		$I->comment("Exiting Action Group [amOnStorefrontPage1] StorefrontOpenHomePageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createCategory1", "hook"); // stepKey: deleteCategory1
		$I->comment("Delete all search terms");
		$I->comment("Entering Action Group [openAdminCatalogSearchTermIndexPage] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchTermIndexPageOpenAdminCatalogSearchTermIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAdminCatalogSearchTermIndexPage
		$I->comment("Exiting Action Group [openAdminCatalogSearchTermIndexPage] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->comment("Delete all search terms");
		$I->comment("Entering Action Group [deleteAllSearchTerms] AdminDeleteAllSearchTermsActionGroup");
		$I->selectOption("//select[@id='search_term_grid_massaction-mass-select']", "selectAll"); // stepKey: checkAllSearchTermsDeleteAllSearchTerms
		$I->selectOption("//div[@class='admin__grid-massaction-form']//select[@id='search_term_grid_massaction-select']", "delete"); // stepKey: selectDeleteOptionDeleteAllSearchTerms
		$I->click("//button[@class='action-default scalable']/span"); // stepKey: clickSubmitButtonDeleteAllSearchTerms
		$I->waitForPageLoad(30); // stepKey: clickSubmitButtonDeleteAllSearchTermsWaitForPageLoad
		$I->click("//button[@class='action-primary action-accept']/span"); // stepKey: clickOkButtonDeleteAllSearchTerms
		$I->waitForPageLoad(30); // stepKey: clickOkButtonDeleteAllSearchTermsWaitForPageLoad
		$I->comment("Exiting Action Group [deleteAllSearchTerms] AdminDeleteAllSearchTermsActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin1] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin1
		$I->comment("Exiting Action Group [logoutOfAdmin1] AdminLogoutActionGroup");
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
	 * @Stories({"Storefront Search"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateSearchTermEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [quickSearchByProductName1] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createProduct1', 'name', 'test')); // stepKey: fillInputQuickSearchByProductName1
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByProductName1
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByProductName1
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByProductName1
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleQuickSearchByProductName1
		$I->see("Search results for: '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByProductName1
		$I->comment("Exiting Action Group [quickSearchByProductName1] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openAdminCatalogSearchTermIndexPage1] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchTermIndexPageOpenAdminCatalogSearchTermIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAdminCatalogSearchTermIndexPage1
		$I->comment("Exiting Action Group [openAdminCatalogSearchTermIndexPage1] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->comment("Entering Action Group [filterByFirstSearchQuery1] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonFilterByFirstSearchQuery1
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonFilterByFirstSearchQuery1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetFilterFilterByFirstSearchQuery1
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", $I->retrieveEntityField('createProduct1', 'name', 'test')); // stepKey: fillSearchQueryFilterByFirstSearchQuery1
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonFilterByFirstSearchQuery1
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonFilterByFirstSearchQuery1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadFilterByFirstSearchQuery1
		$I->checkOption("//*[normalize-space()='" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "']/preceding-sibling::td//input[@name='search']"); // stepKey: checkCheckBoxFilterByFirstSearchQuery1
		$I->waitForPageLoad(30); // stepKey: checkCheckBoxFilterByFirstSearchQuery1WaitForPageLoad
		$I->comment("Exiting Action Group [filterByFirstSearchQuery1] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//a[ancestor::tr[contains(., '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]"); // stepKey: clickOnSearchResult1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Entering Action Group [searchForSearchTerm1] AdminFillAllSearchTermFieldsActionGroup");
		$I->fillField("#query_text", "UpdatedSearchTerm" . msq("UpdatedSearchTermData1")); // stepKey: fillSearchQuery1SearchForSearchTerm1
		$I->selectOption("#store_id", "Default Store View"); // stepKey: selectStore1SearchForSearchTerm1
		$I->fillField("#num_results", "1"); // stepKey: fillNumberOfResults1SearchForSearchTerm1
		$I->fillField("#popularity", "20"); // stepKey: fillNumberOfUses1SearchForSearchTerm1
		$I->selectOption("//select[@name='display_in_terms']", "No"); // stepKey: selectDisplayInSuggestedTerms1SearchForSearchTerm1
		$I->click("#save"); // stepKey: clickOnSaveButton1SearchForSearchTerm1
		$I->comment("Exiting Action Group [searchForSearchTerm1] AdminFillAllSearchTermFieldsActionGroup");
		$I->comment("Entering Action Group [openAdminCatalogSearchTermIndexPage2] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/search/term/index/"); // stepKey: openCatalogSearchTermIndexPageOpenAdminCatalogSearchTermIndexPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenAdminCatalogSearchTermIndexPage2
		$I->comment("Exiting Action Group [openAdminCatalogSearchTermIndexPage2] AdminOpenCatalogSearchTermIndexPageActionGroup");
		$I->comment("Entering Action Group [filterByFirstSearchQuery2] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->click("//button[@class='action-default scalable action-reset action-tertiary']"); // stepKey: clickOnResetButtonFilterByFirstSearchQuery2
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonFilterByFirstSearchQuery2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetFilterFilterByFirstSearchQuery2
		$I->fillField("//tr[@class='data-grid-filters']//td/input[@name='search_query']", "UpdatedSearchTerm" . msq("UpdatedSearchTermData1")); // stepKey: fillSearchQueryFilterByFirstSearchQuery2
		$I->click("//button[@class='action-default scalable action-secondary']"); // stepKey: clickSearchButtonFilterByFirstSearchQuery2
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonFilterByFirstSearchQuery2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchResultLoadFilterByFirstSearchQuery2
		$I->checkOption("//*[normalize-space()='UpdatedSearchTerm" . msq("UpdatedSearchTermData1") . "']/preceding-sibling::td//input[@name='search']"); // stepKey: checkCheckBoxFilterByFirstSearchQuery2
		$I->waitForPageLoad(30); // stepKey: checkCheckBoxFilterByFirstSearchQuery2WaitForPageLoad
		$I->comment("Exiting Action Group [filterByFirstSearchQuery2] AdminSearchTermFilterBySearchQueryActionGroup");
		$I->comment("Entering Action Group [amOnStorefrontPage2] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStorefrontPage2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStorefrontPage2
		$I->comment("Exiting Action Group [amOnStorefrontPage2] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [quickSearchByProductName2] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "UpdatedSearchTerm" . msq("UpdatedSearchTermData1")); // stepKey: fillInputQuickSearchByProductName2
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByProductName2
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByProductName2
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByProductName2
		$I->seeInTitle("Search results for: 'UpdatedSearchTerm" . msq("UpdatedSearchTermData1") . "'"); // stepKey: assertQuickSearchTitleQuickSearchByProductName2
		$I->see("Search results for: 'UpdatedSearchTerm" . msq("UpdatedSearchTermData1") . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByProductName2
		$I->comment("Exiting Action Group [quickSearchByProductName2] StorefrontCheckQuickSearchStringActionGroup");
	}
}
