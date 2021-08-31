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
 * @Title("MC-6494: URL Rewrites for subcategories during creation and move")
 * @Description("Login as admin, move category from one to another and check category url rewrites<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMoveCategoryAndCheckUrlRewritesTest.xml<br>")
 * @TestCaseId("MC-6494")
 * @group mtf_migrated
 */
class AdminMoveCategoryAndCheckUrlRewritesTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$createDefaultCategoryFields['is_active'] = "true";
		$I->createEntity("createDefaultCategory", "hook", "FirstLevelSubCat", [], $createDefaultCategoryFields); // stepKey: createDefaultCategory
		$reindex = $I->magentoCron("index", 90); // stepKey: reindex
		$I->comment($reindex);
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Move categories"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMoveCategoryAndCheckUrlRewritesTest(AcceptanceTester $I)
	{
		$I->comment("Open category page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'FirstLevelSubCategory" . msq("FirstLevelSubCat") . "')]"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Create second level category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonWaitForPageLoad
		$I->fillField("input[name='name']", "SubCategory" . msq("SubCategory")); // stepKey: addSubCategoryName
		$I->comment("Entering Action Group [saveSubCategory1] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory1
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategory1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory1
		$I->comment("Exiting Action Group [saveSubCategory1] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage1
		$I->comment("Create third level category under second level category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton1
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButton1WaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: addSubCategoryName1
		$I->comment("Entering Action Group [saveSubCategory2] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory2
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategory2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory2
		$I->comment("Exiting Action Group [saveSubCategory2] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage2
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Open Url Rewrite Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewritePage
		$I->comment("Search third level category Redirect Path, Target Path and Redirect Type");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "simplesubcategory" . msq("SimpleSubCategory")); // stepKey: fillRequestPathFilter
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad0
		$I->comment("Verify Category RedirectType");
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRedirectType
		$I->comment("Verify Redirect Path");
		$I->see("firstlevelsubcategory" . msq("FirstLevelSubCat") . "2/subcategory" . msq("SubCategory") . "/simplesubcategory" . msq("SimpleSubCategory") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRedirectPath
		$I->comment("Verify Category Target Path");
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheTargetPath
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage1
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree2] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree2
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree2
		$I->comment("Exiting Action Group [clickOnExpandTree2] AdminExpandCategoryTreeActionGroup");
		$I->comment("Move the third level category under first level category");
		$I->dragAndDrop("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]", "//a/span[contains(text(), '" . $I->retrieveEntityField('createDefaultCategory', 'name', 'test') . "')]"); // stepKey: m0oveCategory
		$I->waitForPageLoad(30); // stepKey: m0oveCategoryWaitForPageLoad
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessage
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopup
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3
		$I->see("You moved the category.", ".message-success"); // stepKey: seeSuccessMoveMessage
		$I->comment("Open Url Rewrite page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewritePage1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFilters1WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "firstlevelsubcategory" . msq("FirstLevelSubCat") . "2/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: fillCategoryUrlKey1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad4
		$I->comment("Verify new Redirect Path after move");
		$I->see("firstlevelsubcategory" . msq("FirstLevelSubCat") . "2/simplesubcategory" . msq("SimpleSubCategory") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRequestPathAfterMove
		$I->comment("Verify new Target Path after move");
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheTargetPathAfterMove
		$I->comment("Verify new RedirectType after move");
		$I->see("No", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRedirectTypeAfterMove
		$I->comment("Verify before move Redirect Path displayed with associated Target Path and Redirect Type");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters2
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFilters2WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "simplesubcategory" . msq("SimpleSubCategory")); // stepKey: fillCategoryUrlKey2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters2
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad5
		$I->see("Permanent (301)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRedirectTypeAfterMove1
		$I->see("firstlevelsubcategory" . msq("FirstLevelSubCat") . "2/subcategory" . msq("SubCategory") . "/simplesubcategory" . msq("SimpleSubCategory") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRequestPathAfterMove1
		$I->see("firstlevelsubcategory" . msq("FirstLevelSubCat") . "2/simplesubcategory" . msq("SimpleSubCategory") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheTargetPathAfterMove1
		$I->comment("Verify before move Redirect Path directs to the category page");
		$I->amOnPage("firstlevelsubcategory" . msq("FirstLevelSubCat") . "2/subcategory" . msq("SubCategory") . "/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: openCategoryStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad
		$I->seeElement("//nav//a[span[contains(., 'FirstLevelSubCategory" . msq("FirstLevelSubCat") . "')]]"); // stepKey: seeCategoryOnStoreNavigationBar
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarWaitForPageLoad
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitle
	}
}
