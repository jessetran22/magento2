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
 * @Title("MC-6062: Update category, URL key with custom store view")
 * @Description("Login as admin and update category URL Key with store view<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateCategoryUrlKeyWithStoreViewTest.xml<br>")
 * @TestCaseId("MC-6062")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminUpdateCategoryUrlKeyWithStoreViewTestCest
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
		$I->createEntity("rootCategory", "hook", "NewRootCategory", [], []); // stepKey: rootCategory
		$I->createEntity("category", "hook", "SimpleRootSubCategory", ["rootCategory"], []); // stepKey: category
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
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteCustomStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCustomStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCustomStoreWaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteCustomStore
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
		$I->deleteEntity("rootCategory", "hook"); // stepKey: deleteRootCategory
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
	 * @Stories({"Update categories"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCategoryUrlKeyWithStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("Create Custom Store");
		$I->comment("Entering Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateCustomStore
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateCustomStore
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateCustomStoreWaitForPageLoad
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectMainWebsiteCreateCustomStore
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: fillStoreNameCreateCustomStore
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: fillStoreCodeCreateCustomStore
		$I->selectOption("#group_root_category_id", $I->retrieveEntityField('rootCategory', 'name', 'test')); // stepKey: selectStoreStatusCreateCustomStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateCustomStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateCustomStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateCustomStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateCustomStore
		$I->comment("Exiting Action Group [createCustomStore] CreateCustomStoreActionGroup");
		$I->comment("Create Store View");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreCreateStoreView
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
		$I->comment("Verify Category in Store View");
		$I->comment("Entering Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomepage
		$I->comment("Exiting Action Group [goToHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [switchToCustomStore] StorefrontSwitchStoreActionGroup");
		$I->click("#switcher-store-trigger"); // stepKey: clickOnSwitchStoreButtonSwitchToCustomStore
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStore") . "')]"); // stepKey: selectStoreToSwitchOnSwitchToCustomStore
		$I->waitForPageLoad(30); // stepKey: selectStoreToSwitchOnSwitchToCustomStoreWaitForPageLoad
		$I->comment("Exiting Action Group [switchToCustomStore] StorefrontSwitchStoreActionGroup");
		$I->comment("Entering Action Group [seeCatergoryInStoreFront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., 'SimpleRootSubCategory" . msq("SimpleRootSubCategory") . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCatergoryInStoreFront
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCatergoryInStoreFrontWaitForPageLoad
		$I->comment("Exiting Action Group [seeCatergoryInStoreFront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [selectCategory] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendSelectCategory
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadSelectCategory
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: toCategorySelectCategory
		$I->waitForPageLoad(30); // stepKey: toCategorySelectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageSelectCategory
		$I->comment("Exiting Action Group [selectCategory] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Update URL Key");
		$I->comment("Entering Action Group [openCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryOpenCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryOpenCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerOpenCreatedSubCategory
		$I->comment("Exiting Action Group [openCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKey] ChangeSeoUrlKeyActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKey
		$I->fillField("input[name='url_key']", "newurlkey"); // stepKey: enterURLKeyChangeSeoUrlKey
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKey
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKey
		$I->comment("Exiting Action Group [changeSeoUrlKey] ChangeSeoUrlKeyActionGroup");
		$I->comment("Open Category Store Front Page");
		$I->comment("Entering Action Group [openHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenHomepage
		$I->comment("Exiting Action Group [openHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [seeCatergoryNameInStoreFront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., 'SimpleRootSubCategory" . msq("SimpleRootSubCategory") . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCatergoryNameInStoreFront
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCatergoryNameInStoreFrontWaitForPageLoad
		$I->comment("Exiting Action Group [seeCatergoryNameInStoreFront] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [openCategory] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategory
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategory
		$I->click("//nav//a[span[contains(., 'SimpleRootSubCategory" . msq("SimpleRootSubCategory") . "')]]"); // stepKey: toCategoryOpenCategory
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategory
		$I->comment("Exiting Action Group [openCategory] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Verify Updated URLKey is present");
		$I->comment("Entering Action Group [seeUpdatedUrlkey] StorefrontAssertProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("newurlkey.html"); // stepKey: checkUrlSeeUpdatedUrlkey
		$I->comment("Exiting Action Group [seeUpdatedUrlkey] StorefrontAssertProperUrlIsShownActionGroup");
	}
}
