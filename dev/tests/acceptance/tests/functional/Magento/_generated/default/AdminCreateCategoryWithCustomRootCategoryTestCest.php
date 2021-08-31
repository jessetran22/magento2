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
 * @Title("MC-5272: Create category in the custom root category that is used for custom website")
 * @Description("Login as admin and create a root category with nested sub category and verify category in store front<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryWithCustomRootCategoryTest.xml<br>")
 * @TestCaseId("MC-5272")
 * @group mtf_migrated
 * @group Catalog
 */
class AdminCreateCategoryWithCustomRootCategoryTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCustomStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCustomStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCustomStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStoreGroup")); // stepKey: fillSearchStoreGroupFieldDeleteCustomStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomStoreWaitForPageLoad
		$I->see("store" . msq("customStoreGroup"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCustomStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCustomStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteCustomStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCustomStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomStore
		$I->comment("Exiting Action Group [deleteCustomStore] DeleteCustomStoreActionGroup");
		$I->comment("Entering Action Group [deleteCreatedNewRootCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCreatedNewRootCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCreatedNewRootCategory
		$I->click("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCreatedNewRootCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCreatedNewRootCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCreatedNewRootCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCreatedNewRootCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCreatedNewRootCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCreatedNewRootCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCreatedNewRootCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCreatedNewRootCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCreatedNewRootCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCreatedNewRootCategory
		$I->dontSee("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCreatedNewRootCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCreatedNewRootCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCreatedNewRootCategory] DeleteCategoryActionGroup");
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
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryWithCustomRootCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Create Root Category");
		$I->comment("Entering Action Group [createNewRootCategory] AdminCreateRootCategory");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateNewRootCategory
		$I->click("#add_root_category_button"); // stepKey: clickOnAddRootCategoryButtonCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddRootCategoryButtonCreateNewRootCategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateNewRootCategory
		$I->fillField("input[name='name']", "NewRootCategory" . msq("NewRootCategory")); // stepKey: enterNewRootCategoryNameCreateNewRootCategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateNewRootCategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "newrootcategory" . msq("NewRootCategory")); // stepKey: enterURLKeyCreateNewRootCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateNewRootCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearCreateNewRootCategory
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateNewRootCategory
		$I->seeInTitle("NewRootCategory" . msq("NewRootCategory")); // stepKey: seeNewCategoryPageTitleCreateNewRootCategory
		$I->seeElement("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: seeCategoryInTreeCreateNewRootCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateNewRootCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createNewRootCategory] AdminCreateRootCategory");
		$I->comment("Create subcategory");
		$I->comment("Entering Action Group [openCreatedCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenCreatedCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenCreatedCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenCreatedCategory
		$I->click("//a/span[contains(text(), 'NewRootCategory" . msq("NewRootCategory") . "')]"); // stepKey: navigateToCreatedCategoryOpenCreatedCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenCreatedCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenCreatedCategory
		$I->comment("Exiting Action Group [openCreatedCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [createSubcategory] CreateCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateSubcategory
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateSubcategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateSubcategory
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryNameCreateSubcategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateSubcategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplesubcategory" . msq("SimpleSubCategory")); // stepKey: enterURLKeyCreateSubcategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateSubcategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateSubcategory
		$I->seeInTitle("SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: seeNewCategoryPageTitleCreateSubcategory
		$I->seeElement("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: seeCategoryInTreeCreateSubcategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateSubcategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createSubcategory] CreateCategoryActionGroup");
		$I->comment("Create a Store");
		$I->comment("Entering Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStore
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreWaitForPageLoad
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectMainWebsiteCreateCustomStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: fillStoreNameCreateCustomStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: fillStoreCodeCreateCustomStore
		$I->selectOption("#group_root_category_id", "NewRootCategory" . msq("NewRootCategory")); // stepKey: selectStoreStatusCreateCustomStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStore
		$I->comment("Exiting Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->comment("Create a Store View");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Go to store front page");
		$I->comment("Entering Action Group [openHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenHomepage
		$I->comment("Exiting Action Group [openHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Verify subcategory displayed in store front page");
		$I->comment("Entering Action Group [switchToCustomStore] StorefrontSwitchStoreActionGroup");
		$I->click("#switcher-store-trigger"); // stepKey: clickOnSwitchStoreButtonSwitchToCustomStore
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStoreGroup") . "')]"); // stepKey: selectStoreToSwitchOnSwitchToCustomStore
		$I->waitForPageLoad(30); // stepKey: selectStoreToSwitchOnSwitchToCustomStoreWaitForPageLoad
		$I->comment("Exiting Action Group [switchToCustomStore] StorefrontSwitchStoreActionGroup");
		$I->comment("Entering Action Group [seeCatergoryNameInStoreFront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCatergoryNameInStoreFront
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCatergoryNameInStoreFrontWaitForPageLoad
		$I->comment("Exiting Action Group [seeCatergoryNameInStoreFront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
	}
}
