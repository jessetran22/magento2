<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MAGETWO-94995: Product quick search doesn't throw exception after ES is chosen as search engine")
 * @Description("Verify no elastic search exception is thrown when searching for product before catalogsearch reindexing<h3>Test files</h3>app/code/Magento/Elasticsearch/Test/Mftf/Test/ProductQuickSearchUsingElasticSearchTest.xml<br>")
 * @TestCaseId("MAGETWO-94995")
 * @group Catalog
 * @group SearchEngineElasticsearch
 */
class ProductQuickSearchUsingElasticSearchTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("categoryFirst", "hook", "SimpleSubCategory", [], []); // stepKey: categoryFirst
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct", ["categoryFirst"], []); // stepKey: simpleProduct1
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("categoryFirst", "hook"); // stepKey: deleteCategory
		$I->comment("The test was moved to elasticsearch suite");
		$I->comment("Entering Action Group [resetIndexerBackToOriginalState] AdminIndexerSetUpdateOnSaveActionGroup");
		$I->amOnPage(getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: amOnIndexManagementPage2ResetIndexerBackToOriginalState
		$I->waitForPageLoad(30); // stepKey: waitForIndexManagementPageToLoad2ResetIndexerBackToOriginalState
		$I->click("input[value='catalogsearch_fulltext']"); // stepKey: selectIndexer2ResetIndexerBackToOriginalState
		$I->selectOption("#gridIndexer_massaction-select", "change_mode_onthefly"); // stepKey: selectUpdateOnSaveResetIndexerBackToOriginalState
		$I->click("#gridIndexer_massaction-form button"); // stepKey: submitIndexerForm2ResetIndexerBackToOriginalState
		$I->comment("No re-indexing is done as part of this actionGroup since the test required no re-indexing");
		$I->waitForPageLoad(30); // stepKey: waitForSave2ResetIndexerBackToOriginalState
		$I->comment("Exiting Action Group [resetIndexerBackToOriginalState] AdminIndexerSetUpdateOnSaveActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Elasticsearch"})
	 * @Stories({"Quick Search of products on Storefront when ES 5.x is enabled"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ProductQuickSearchUsingElasticSearchTest(AcceptanceTester $I)
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
		$I->comment("Change Catalog search engine option to Elastic Search 5.0+");
		$I->comment("The test was moved to elasticsearch suite");
		$I->comment("Entering Action Group [clearing] ClearPageCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementPageClearing
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearing
		$I->click("//*[@id='cache_grid_massaction-select']//option[contains(., 'Action')]"); // stepKey: actionSelectionClearing
		$I->waitForPageLoad(30); // stepKey: actionSelectionClearingWaitForPageLoad
		$I->click("//*[@id='cache_grid_massaction-select']//option[@value='refresh']"); // stepKey: selectRefreshOptionClearing
		$I->waitForPageLoad(30); // stepKey: selectRefreshOptionClearingWaitForPageLoad
		$I->click("//td[contains(., 'Page Cache')]/..//input[@type='checkbox']"); // stepKey: selectPageCacheRowCheckboxClearing
		$I->click("//button[@title='Submit']"); // stepKey: clickSubmitClearing
		$I->waitForPageLoad(30); // stepKey: clickSubmitClearingWaitForPageLoad
		$I->comment("Exiting Action Group [clearing] ClearPageCacheActionGroup");
		$I->comment("Entering Action Group [updateAnIndexerBySchedule] UpdateIndexerByScheduleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/indexer/indexer/list/"); // stepKey: amOnIndexManagementPageUpdateAnIndexerBySchedule
		$I->waitForPageLoad(30); // stepKey: waitForIndexManagementPageToLoadUpdateAnIndexerBySchedule
		$I->click("input[value='catalogsearch_fulltext']"); // stepKey: selectIndexer1UpdateAnIndexerBySchedule
		$I->selectOption("#gridIndexer_massaction-select", "change_mode_changelog"); // stepKey: selectUpdateByScheduleUpdateAnIndexerBySchedule
		$I->click("#gridIndexer_massaction-form button"); // stepKey: submitIndexerFormUpdateAnIndexerBySchedule
		$I->comment("No re-indexing is done as part of this actionGroup since the test required no re-indexing");
		$I->waitForPageLoad(30); // stepKey: waitForSaveUpdateAnIndexerBySchedule
		$I->comment("Exiting Action Group [updateAnIndexerBySchedule] UpdateIndexerByScheduleActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Navigate to storefront and do a quick search for the product");
		$I->comment("Navigate to Storefront to check if quick search works");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->fillField("#search", "Simple"); // stepKey: fillSearchBar
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->click("button.action.search"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrl
		$I->seeInTitle("Search results for: 'Simple'"); // stepKey: assertQuickSearchTitle
		$I->see("Search results for: 'Simple'", ".page-title span"); // stepKey: assertQuickSearchName
		$I->comment("End of searching products");
		$I->comment("Entering Action Group [loginAsAdmin2] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin2
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin2
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin2
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin2
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin2WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin2
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin2
		$I->comment("Exiting Action Group [loginAsAdmin2] AdminLoginActionGroup");
	}
}
