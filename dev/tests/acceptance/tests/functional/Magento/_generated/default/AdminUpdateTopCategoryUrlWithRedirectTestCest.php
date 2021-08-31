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
 * @Title("MC-6057: Update top category url and create redirect")
 * @Description("Login as admin and update top category url and create redirect<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateTopCategoryUrlWithRedirectTest.xml<br>")
 * @TestCaseId("MC-6057")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminUpdateTopCategoryUrlWithRedirectTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create three level nested category");
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
		$I->createEntity("createTwoLevelNestedCategories", "hook", "Two_nested_categories", ["createDefaultCategory"], []); // stepKey: createTwoLevelNestedCategories
		$I->createEntity("createThreeLevelNestedCategories", "hook", "Three_nested_categories", ["createTwoLevelNestedCategories"], []); // stepKey: createThreeLevelNestedCategories
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createThreeLevelNestedCategories", "hook"); // stepKey: deleteThreeNestedCategories
		$I->deleteEntity("createTwoLevelNestedCategories", "hook"); // stepKey: deleteTwoLevelNestedCategory
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteDefaultCategory
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
	 * @Stories({"Update category"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateTopCategoryUrlWithRedirectTest(AcceptanceTester $I)
	{
		$I->comment("Open Category page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Open 3rd Level category");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createThreeLevelNestedCategories', 'name', 'test') . "')]"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Update category UrlKey and check permanent redirect for old URL");
		$I->scrollTo("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", 0, -80); // stepKey: scrollToSearchEngineOptimization1
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineOptimization1WaitForPageLoad
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: selectSearchEngineOptimization
		$I->waitForPageLoad(30); // stepKey: selectSearchEngineOptimizationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1
		$I->fillField("input[name='url_key']", "updateredirecturl"); // stepKey: updateUrlKey
		$I->checkOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: checkPermanentRedirectCheckBox
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: selectSearchEngineOptimization1
		$I->waitForPageLoad(30); // stepKey: selectSearchEngineOptimization1WaitForPageLoad
		$I->comment("Entering Action Group [saveUpdatedCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveUpdatedCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveUpdatedCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveUpdatedCategory
		$I->comment("Exiting Action Group [saveUpdatedCategory] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage
		$I->comment("Get Category ID");
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Open Url Rewrite Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewritePage
		$I->comment("Verify third level category's Redirect Path, Target Path and Redirect Type after the URL update");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickOnResetButton
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "updateredirecturl"); // stepKey: fillUpdatedURLInRedirectPathFilter
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectType
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPath
		$I->see($I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "/" . $I->retrieveEntityField('createTwoLevelNestedCategories', 'name', 'test') . "/updateredirecturl.html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPath
		$I->comment("Verify third level category's Redirect path, Target Path and Redirect type for old URL");
		$I->comment("Entering Action Group [clickOnResetButton1] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickOnResetButton1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickOnResetButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickOnResetButton1
		$I->comment("Exiting Action Group [clickOnResetButton1] AdminClearGridFiltersActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFilters1WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createThreeLevelNestedCategories', 'name', 'test')); // stepKey: fillOldUrlInRedirectPathFilter
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad5
		$I->see($I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "/" . $I->retrieveEntityField('createTwoLevelNestedCategories', 'name', 'test') . "/" . $I->retrieveEntityField('createThreeLevelNestedCategories', 'name', 'test') . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectPathForOldUrl
		$I->see($I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "/" . $I->retrieveEntityField('createTwoLevelNestedCategories', 'name', 'test') . "/updateredirecturl.html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: seeTheTargetPathForOldUrl
		$I->see("Permanent (301)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: seeTheRedirectTypeForOldUrl
	}
}
