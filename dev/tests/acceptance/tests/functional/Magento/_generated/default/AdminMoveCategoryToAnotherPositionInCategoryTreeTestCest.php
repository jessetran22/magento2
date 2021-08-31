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
 * @Title("MC-13612: Move Category to Another Position in Category Tree")
 * @Description("Test log in to Move Category and Move Category to Another Position in Category Tree<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMoveCategoryToAnotherPositionInCategoryTreeTest.xml<br>")
 * @TestCaseId("MC-13612")
 * @group catalog
 * @group mtf_migrated
 */
class AdminMoveCategoryToAnotherPositionInCategoryTreeTestCest
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
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteDefaultCategory
		$I->comment("Entering Action Group [SecondLevelSubCat] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageSecondLevelSubCat
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadSecondLevelSubCat
		$I->click("//a/span[contains(text(), 'SecondLevelSubCategory" . msq("SecondLevelSubCat") . "')]"); // stepKey: clickCategoryLinkSecondLevelSubCat
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkSecondLevelSubCatWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteSecondLevelSubCat
		$I->waitForPageLoad(30); // stepKey: clickDeleteSecondLevelSubCatWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalSecondLevelSubCat
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageSecondLevelSubCat
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteSecondLevelSubCat
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishSecondLevelSubCat
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessSecondLevelSubCat
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesSecondLevelSubCat
		$I->dontSee("//a/span[contains(text(), 'SecondLevelSubCategory" . msq("SecondLevelSubCat") . "')]"); // stepKey: dontSeeCategoryInTreeSecondLevelSubCat
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeSecondLevelSubCatWaitForPageLoad
		$I->comment("Exiting Action Group [SecondLevelSubCat] DeleteCategoryActionGroup");
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMoveCategoryToAnotherPositionInCategoryTreeTest(AcceptanceTester $I)
	{
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickExpandTree
		$I->comment("Exiting Action Group [clickExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Create three level deep sub Category");
		$I->click("#add_subcategory_button"); // stepKey: clickAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickAddSubCategoryButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddSubCategoryClick1
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitForSubCategoryName1
		$I->fillField("input[name='name']", "FirstLevelSubCategory" . msq("FirstLevelSubCat")); // stepKey: fillSubCategoryName
		$I->comment("Entering Action Group [saveFirstLevelSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveFirstLevelSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveFirstLevelSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveFirstLevelSubCategory
		$I->comment("Exiting Action Group [saveFirstLevelSubCategory] AdminSaveCategoryActionGroup");
		$I->waitForElementVisible(".message-success", 30); // stepKey: seeSuccessMessage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButtonAgain
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddSubCategoryClick2
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitForSubCategoryName2
		$I->fillField("input[name='name']", "SecondLevelSubCategory" . msq("SecondLevelSubCat")); // stepKey: fillSecondLevelSubCategoryName
		$I->comment("Entering Action Group [saveSecondLevelSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSecondLevelSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSecondLevelSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSecondLevelSubCategory
		$I->comment("Exiting Action Group [saveSecondLevelSubCategory] AdminSaveCategoryActionGroup");
		$I->waitForElementVisible(".message-success", 30); // stepKey: seeSaveSuccessMessage
		$categoryId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: categoryId
		$I->comment("Move Category to another position in category tree, but click cancel button");
		$I->dragAndDrop("//a/span[contains(text(), 'SecondLevelSubCategory" . msq("SecondLevelSubCat") . "')]", "//a/span[contains(text(), 'Default Category')]"); // stepKey: moveCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryWaitForPageLoad
		$I->waitForText("This operation can take a long time", 30, "aside.confirm div.modal-content"); // stepKey: seeWarningMessage
		$I->click("aside.confirm .modal-footer .action-secondary"); // stepKey: clickCancelButtonOnWarningPopup
		$I->comment("Verify Category in store front page after clicking cancel button");
		$I->amOnPage("/" . $I->retrieveEntityField('createDefaultCategory', 'custom_attributes[url_key]', 'test') . "/firstlevelsubcategory" . msq("FirstLevelSubCat") . "/secondlevelsubcategory" . msq("SecondLevelSubCat") . ".html"); // stepKey: seeTheCategoryInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontPageLoad
		$I->waitForElementVisible("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]", 30); // stepKey: seeDefaultCategoryOnStoreNavigationBar
		$I->waitForPageLoad(30); // stepKey: seeDefaultCategoryOnStoreNavigationBarWaitForPageLoad
		$I->dontSeeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: dontSeeSubCategoryOnStoreNavigationBar
		$I->waitForPageLoad(30); // stepKey: dontSeeSubCategoryOnStoreNavigationBarWaitForPageLoad
		$I->comment("Verify breadcrumbs in store front page after clicking cancel button");
		$breadcrumbs = $I->grabMultiple(".breadcrumbs li"); // stepKey: breadcrumbs
		$I->assertEquals(['Home', $I->retrieveEntityField('createDefaultCategory', 'name', 'test'), "FirstLevelSubCategory" . msq("FirstLevelSubCat"), "SecondLevelSubCategory" . msq("SecondLevelSubCat")], $breadcrumbs); // stepKey: verifyTheCategoryInStoreFrontPage
		$I->comment("Move Category to another position in category tree and click ok button");
		$I->comment("Entering Action Group [openTheAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenTheAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenTheAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openTheAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->dragAndDrop("//a/span[contains(text(), 'SecondLevelSubCategory" . msq("SecondLevelSubCat") . "')]", "//a/span[contains(text(), 'Default Category')]"); // stepKey: DragCategory
		$I->waitForPageLoad(30); // stepKey: DragCategoryWaitForPageLoad
		$I->waitForText("This operation can take a long time", 30, "aside.confirm div.modal-content"); // stepKey: seeWarningMessageForOneMoreTime
		$I->waitForElementVisible("aside.confirm .modal-footer .action-primary", 30); // stepKey: waitForOkButtonOnWarningPopup
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopup
		$I->waitForPageLoad(30); // stepKey: waitTheForPageToLoad
		$I->waitForText("You moved the category.", 30, ".message-success"); // stepKey: seeSuccessMoveMessage
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: seeCategoryNameInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontPageToLoad
		$I->comment("Verify Category in store front after moving category to another position in category tree");
		$I->amOnPage("/secondlevelsubcategory" . msq("SecondLevelSubCat") . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToBeLoaded
		$I->waitForElementVisible("#page-title-heading span", 30); // stepKey: seeCategoryInTitle
		$I->waitForElementVisible("//nav//a[span[contains(., 'SecondLevelSubCategory" . msq("SecondLevelSubCat") . "')]]", 30); // stepKey: seeCategoryOnStoreNavigationBarAfterMove
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarAfterMoveWaitForPageLoad
		$I->comment("Verify breadcrumbs in store front page after moving category to another position in category tree");
		$I->click("//nav//a[span[contains(., 'SecondLevelSubCategory" . msq("SecondLevelSubCat") . "')]]"); // stepKey: clickCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: clickCategoryOnNavigationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryLoad
		$breadcrumbsAfterMove = $I->grabMultiple(".breadcrumbs li"); // stepKey: breadcrumbsAfterMove
		$I->assertEquals(['Home', "SecondLevelSubCategory" . msq("SecondLevelSubCat")], $breadcrumbsAfterMove); // stepKey: verifyBreadcrumbsInFrontPageAfterMove
		$I->comment("Open Url Rewrite page and see the url rewrite for the moved category");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewritePageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersWaitForPageLoad
		$I->waitForElementVisible(".admin__data-grid-filters input[name='request_path']", 30); // stepKey: waitForCategoryUrlKey
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "secondlevelsubcategory" . msq("SecondLevelSubCat") . ".html"); // stepKey: fillCategoryUrlKey
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearch
		$I->comment("Verify new Redirect Path after move");
		$I->see("secondlevelsubcategory" . msq("SecondLevelSubCat") . ".html", "//*[@data-role='grid']//tbody//tr[2+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRequestPathAfterMove
		$I->comment("Verify new Target Path after move");
		$I->see("catalog/category/view/id/{$categoryId}", "//*[@data-role='grid']//tbody//tr[2+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheTargetPathAfterMove
		$I->comment("Verify new RedirectType after move");
		$I->see("No", "//*[@data-role='grid']//tbody//tr[2+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRedirectTypeAfterMove
		$I->comment("Verify before move Redirect Path displayed with associated Target Path and Redirect Type");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters1
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFilters1WaitForPageLoad
		$I->waitForElementVisible(".admin__data-grid-filters input[name='request_path']", 30); // stepKey: waitForTheCategoryUrlKey
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "secondlevelsubcategory" . msq("SecondLevelSubCat")); // stepKey: fillTheCategoryUrlKey
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearch1
		$I->see("Permanent (301)", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Redirect Type')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRedirectTypeBeforeMove
		$I->see("simplecategory" . msq("_defaultCategory") . "2/firstlevelsubcategory" . msq("FirstLevelSubCat") . "/secondlevelsubcategory" . msq("SecondLevelSubCat") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheRequestPathBeforeMove
		$I->see("secondlevelsubcategory" . msq("SecondLevelSubCat") . ".html", "//*[@data-role='grid']//tbody//tr[1+1]//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1]"); // stepKey: verifyTheTargetPathBeforeMove
	}
}
