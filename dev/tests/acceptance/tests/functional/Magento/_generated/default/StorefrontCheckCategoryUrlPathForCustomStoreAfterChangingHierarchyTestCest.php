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
 * @Title("MC-41615: Checking category URL path for custom store after changing hierarchy")
 * @Description("Checks that category and its children have correct URL path for custom store after changing hierarchy<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/StorefrontCheckCategoryUrlPathForCustomStoreAfterChangingHierarchyTest.xml<br>")
 * @TestCaseId("MC-41615")
 * @group catalog
 * @group urlRewrite
 */
class StorefrontCheckCategoryUrlPathForCustomStoreAfterChangingHierarchyTestCest
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
		$I->comment("Create categories");
		$I->createEntity("createCategory1", "hook", "_defaultCategory", [], []); // stepKey: createCategory1
		$I->createEntity("createCategory2", "hook", "SubCategoryWithParent", ["createCategory1"], []); // stepKey: createCategory2
		$I->createEntity("createCategory3", "hook", "_defaultCategory", [], []); // stepKey: createCategory3
		$I->createEntity("createCategory4", "hook", "_defaultCategory", [], []); // stepKey: createCategory4
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create \"EN\" Store View");
		$I->comment("Entering Action Group [createEnStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateEnStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateEnStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateEnStoreView
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateEnStoreView
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateEnStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateEnStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateEnStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateEnStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateEnStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateEnStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateEnStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateEnStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateEnStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateEnStoreView
		$I->comment("Exiting Action Group [createEnStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete categories");
		$I->deleteEntity("createCategory4", "hook"); // stepKey: deleteCategory4
		$I->deleteEntity("createCategory3", "hook"); // stepKey: deleteCategory3
		$I->deleteEntity("createCategory2", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("createCategory1", "hook"); // stepKey: deleteCategory1
		$I->comment("Entering Action Group [deleteEnStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteEnStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteEnStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteEnStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteEnStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteEnStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteEnStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteEnStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteEnStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteEnStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteEnStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteEnStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteEnStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteEnStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteEnStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteEnStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteEnStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteEnStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteEnStoreView
		$I->comment("Exiting Action Group [deleteEnStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Clear grid filters");
		$I->comment("Entering Action Group [clearStoreFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearStoreFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearStoreFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearStoreFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"CatalogUrlRewrite"})
	 * @Stories({"Url rewrites"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckCategoryUrlPathForCustomStoreAfterChangingHierarchyTest(AcceptanceTester $I)
	{
		$I->comment("Go to Category 1 edit page on \"EN\" store view");
		$I->comment("Entering Action Group [goToCategory1PageOnEnStoreView] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageGoToCategory1PageOnEnStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1GoToCategory1PageOnEnStoreView
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory1', 'name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryGoToCategory1PageOnEnStoreView
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryGoToCategory1PageOnEnStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2GoToCategory1PageOnEnStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerGoToCategory1PageOnEnStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleGoToCategory1PageOnEnStoreView
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownGoToCategory1PageOnEnStoreView
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='EN" . msq("customStoreEN") . "']"); // stepKey: selectStoreViewGoToCategory1PageOnEnStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3GoToCategory1PageOnEnStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2GoToCategory1PageOnEnStoreView
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptGoToCategory1PageOnEnStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadGoToCategory1PageOnEnStoreView
		$I->comment("Exiting Action Group [goToCategory1PageOnEnStoreView] SwitchCategoryStoreViewActionGroup");
		$I->comment("Change Name and URL key for Category 1");
		$I->comment("Entering Action Group [changeCategory1NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckUseDefaultValueENStoreViewChangeCategory1NameForEnStoreView
		$I->fillField("input[name='name']", "EN 1"); // stepKey: changeNameFieldChangeCategory1NameForEnStoreView
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: clickOnSectionHeaderChangeCategory1NameForEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnSectionHeaderChangeCategory1NameForEnStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [changeCategory1NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->comment("Entering Action Group [changeCategory1UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeCategory1UrlKeyForEnStoreView
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeCategory1UrlKeyForEnStoreView
		$I->fillField("input[name='url_key']", "en 1"); // stepKey: enterURLKeyChangeCategory1UrlKeyForEnStoreView
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeCategory1UrlKeyForEnStoreView
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeCategory1UrlKeyForEnStoreView
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeCategory1UrlKeyForEnStoreViewWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeCategory1UrlKeyForEnStoreView
		$I->comment("Exiting Action Group [changeCategory1UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Change Name and URL key for Category 2");
		$I->comment("Entering Action Group [openCategory2EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory2', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory2EditPage
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategory2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory2EditPage
		$I->comment("Exiting Action Group [openCategory2EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [changeCategory2NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckUseDefaultValueENStoreViewChangeCategory2NameForEnStoreView
		$I->fillField("input[name='name']", "EN 2"); // stepKey: changeNameFieldChangeCategory2NameForEnStoreView
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: clickOnSectionHeaderChangeCategory2NameForEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnSectionHeaderChangeCategory2NameForEnStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [changeCategory2NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->comment("Entering Action Group [changeCategory2UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeCategory2UrlKeyForEnStoreView
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeCategory2UrlKeyForEnStoreView
		$I->fillField("input[name='url_key']", "en 2"); // stepKey: enterURLKeyChangeCategory2UrlKeyForEnStoreView
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeCategory2UrlKeyForEnStoreView
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeCategory2UrlKeyForEnStoreView
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeCategory2UrlKeyForEnStoreViewWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeCategory2UrlKeyForEnStoreView
		$I->comment("Exiting Action Group [changeCategory2UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Change Name and URL key for Category 3");
		$I->comment("Entering Action Group [openCategory3EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory3', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory3EditPage
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategory3EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory3EditPage
		$I->comment("Exiting Action Group [openCategory3EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [changeCategory3NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckUseDefaultValueENStoreViewChangeCategory3NameForEnStoreView
		$I->fillField("input[name='name']", "EN 3"); // stepKey: changeNameFieldChangeCategory3NameForEnStoreView
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: clickOnSectionHeaderChangeCategory3NameForEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnSectionHeaderChangeCategory3NameForEnStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [changeCategory3NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->comment("Entering Action Group [changeCategory3UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeCategory3UrlKeyForEnStoreView
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeCategory3UrlKeyForEnStoreView
		$I->fillField("input[name='url_key']", "en 3"); // stepKey: enterURLKeyChangeCategory3UrlKeyForEnStoreView
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeCategory3UrlKeyForEnStoreView
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeCategory3UrlKeyForEnStoreView
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeCategory3UrlKeyForEnStoreViewWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeCategory3UrlKeyForEnStoreView
		$I->comment("Exiting Action Group [changeCategory3UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Change Name and URL key for Category 4");
		$I->comment("Entering Action Group [openCategory4EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory4', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory4EditPage
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategory4EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory4EditPage
		$I->comment("Exiting Action Group [openCategory4EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [changeCategory4NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckUseDefaultValueENStoreViewChangeCategory4NameForEnStoreView
		$I->fillField("input[name='name']", "EN 4"); // stepKey: changeNameFieldChangeCategory4NameForEnStoreView
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: clickOnSectionHeaderChangeCategory4NameForEnStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnSectionHeaderChangeCategory4NameForEnStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [changeCategory4NameForEnStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->comment("Entering Action Group [changeCategory4UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeCategory4UrlKeyForEnStoreView
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeCategory4UrlKeyForEnStoreView
		$I->fillField("input[name='url_key']", "en 4"); // stepKey: enterURLKeyChangeCategory4UrlKeyForEnStoreView
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeCategory4UrlKeyForEnStoreView
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeCategory4UrlKeyForEnStoreView
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeCategory4UrlKeyForEnStoreViewWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeCategory4UrlKeyForEnStoreView
		$I->comment("Exiting Action Group [changeCategory4UrlKeyForEnStoreView] AdminChangeSeoUrlKeyForSubCategoryWithoutRedirectActionGroup");
		$I->comment("Go to Home page on the Storefront");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Switch store view to 'EN'");
		$I->comment("Entering Action Group [switchStoreViewToEn] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStoreViewToEn
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStoreViewToEn
		$I->click("li.view-en" . msq("customStoreEN") . ">a"); // stepKey: clickSelectStoreViewSwitchStoreViewToEn
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStoreViewToEn
		$I->comment("Exiting Action Group [switchStoreViewToEn] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Assert Category 2 URL path on the 'EN' store view");
		$I->comment("Entering Action Group [navigateToCategory2Page] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendNavigateToCategory2Page
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadNavigateToCategory2Page
		$I->moveMouseOver("//nav//a[span[contains(., 'EN 1')]]"); // stepKey: toCategoryNavigateToCategory2Page
		$I->waitForPageLoad(30); // stepKey: toCategoryNavigateToCategory2PageWaitForPageLoad
		$I->click("//nav//a[span[contains(., 'EN 2')]]"); // stepKey: openSubCategoryNavigateToCategory2Page
		$I->waitForPageLoad(30); // stepKey: openSubCategoryNavigateToCategory2PageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageNavigateToCategory2Page
		$I->comment("Exiting Action Group [navigateToCategory2Page] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertUrlPathForCategory2] StorefrontAssertProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("/en-1/en-2.html"); // stepKey: checkUrlAssertUrlPathForCategory2
		$I->comment("Exiting Action Group [assertUrlPathForCategory2] StorefrontAssertProperUrlIsShownActionGroup");
		$I->comment("Go to Categories page on the Admin");
		$I->comment("Entering Action Group [goToAdminCategoriesPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToAdminCategoriesPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToAdminCategoriesPage
		$I->comment("Exiting Action Group [goToAdminCategoriesPage] AdminOpenCategoryPageActionGroup");
		$I->see("All Store View", "#store-change-button"); // stepKey: assertAllStoreView
		$I->comment("Move Category 2 to 'Default Category'");
		$I->comment("Entering Action Group [moveCategory2ToDefaultCategory] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveCategory2ToDefaultCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveCategory2ToDefaultCategory
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory2', 'name', 'test') . "')]", "//a/span[contains(text(), 'Default Category')]"); // stepKey: moveCategoryMoveCategory2ToDefaultCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveCategory2ToDefaultCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveCategory2ToDefaultCategory
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveCategory2ToDefaultCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveCategory2ToDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveCategory2ToDefaultCategory
		$I->comment("Exiting Action Group [moveCategory2ToDefaultCategory] MoveCategoryActionGroup");
		$I->comment("Move Category 4 to Category 3");
		$I->comment("Entering Action Group [moveCategory4ToCategory3] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveCategory4ToCategory3
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveCategory4ToCategory3
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory4', 'name', 'test') . "')]", "//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory3', 'name', 'test') . "')]"); // stepKey: moveCategoryMoveCategory4ToCategory3
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveCategory4ToCategory3WaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveCategory4ToCategory3
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveCategory4ToCategory3
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveCategory4ToCategory3
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveCategory4ToCategory3
		$I->comment("Exiting Action Group [moveCategory4ToCategory3] MoveCategoryActionGroup");
		$I->comment("Create Category 5");
		$I->comment("Entering Action Group [navigateToCategory2EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory2', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkNavigateToCategory2EditPage
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkNavigateToCategory2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategory2EditPage
		$I->comment("Exiting Action Group [navigateToCategory2EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->click("#add_subcategory_button"); // stepKey: clickToAddCategory5
		$I->waitForPageLoad(30); // stepKey: clickToAddCategory5WaitForPageLoad
		$I->checkOption("input[name='is_active']"); // stepKey: enableCategory5
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: fillCategory5Name
		$I->comment("Entering Action Group [saveCategory5] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategory5
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategory5WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategory5
		$I->comment("Exiting Action Group [saveCategory5] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertCategory5Saved] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertCategory5Saved
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertCategory5Saved
		$I->comment("Exiting Action Group [assertCategory5Saved] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Assert Category 5 URL path on the 'EN' store view");
		$I->comment("Entering Action Group [navigateToCategory5Page] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendNavigateToCategory5Page
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadNavigateToCategory5Page
		$I->moveMouseOver("//nav//a[span[contains(., 'EN 2')]]"); // stepKey: toCategoryNavigateToCategory5Page
		$I->waitForPageLoad(30); // stepKey: toCategoryNavigateToCategory5PageWaitForPageLoad
		$I->click("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: openSubCategoryNavigateToCategory5Page
		$I->waitForPageLoad(30); // stepKey: openSubCategoryNavigateToCategory5PageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageNavigateToCategory5Page
		$I->comment("Exiting Action Group [navigateToCategory5Page] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertUrlPathForCategory5] StorefrontAssertProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl("en-2/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: checkUrlAssertUrlPathForCategory5
		$I->comment("Exiting Action Group [assertUrlPathForCategory5] StorefrontAssertProperUrlIsShownActionGroup");
		$I->comment("Go to Category 2 edit page on \"EN\" store view");
		$I->comment("Entering Action Group [goToAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToAdminCategoryIndexPage
		$I->comment("Exiting Action Group [goToAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToCategory2EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory2', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkGoToCategory2EditPage
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkGoToCategory2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoToCategory2EditPage
		$I->comment("Exiting Action Group [goToCategory2EditPage] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [switchToDefaultStoreView] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownSwitchToDefaultStoreView
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleSwitchToDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleSwitchToDefaultStoreViewWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'EN" . msq("customStoreEN") . "')]"); // stepKey: clickStoreViewByNameSwitchToDefaultStoreView
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameSwitchToDefaultStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalSwitchToDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalSwitchToDefaultStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchSwitchToDefaultStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchSwitchToDefaultStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedSwitchToDefaultStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherSwitchToDefaultStoreView
		$I->see("EN" . msq("customStoreEN"), ".store-switcher"); // stepKey: seeNewStoreViewNameSwitchToDefaultStoreView
		$I->comment("Exiting Action Group [switchToDefaultStoreView] AdminSwitchStoreViewActionGroup");
		$I->comment("Change Category 2 URL key to default value");
		$I->comment("Entering Action Group [changeCategory2UrlKeyToDefaultValue] AdminChangeSeoUrlKeyToDefaultValueWithoutRedirectActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "input[name='url_key']", false); // stepKey: clickOnSEOTabChangeCategory2UrlKeyToDefaultValue
		$I->waitForElementVisible("input[name='url_key']", 30); // stepKey: waitForSEOTabOpenedChangeCategory2UrlKeyToDefaultValue
		$I->clearField("input[name='url_key']"); // stepKey: clearUrlKeyFieldChangeCategory2UrlKeyToDefaultValue
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirectCheckboxChangeCategory2UrlKeyToDefaultValue
		$I->checkOption("input[name='use_default[url_key]']"); // stepKey: checkUseDefaultValueCheckboxChangeCategory2UrlKeyToDefaultValue
		$I->comment("Exiting Action Group [changeCategory2UrlKeyToDefaultValue] AdminChangeSeoUrlKeyToDefaultValueWithoutRedirectActionGroup");
		$I->comment("Entering Action Group [saveCategory2] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategory2
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategory2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategory2
		$I->comment("Exiting Action Group [saveCategory2] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertCategory2Saved] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertCategory2Saved
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertCategory2Saved
		$I->comment("Exiting Action Group [assertCategory2Saved] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Go to Home page on the Storefront");
		$I->comment("Entering Action Group [navigateToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageNavigateToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadNavigateToHomePage
		$I->comment("Exiting Action Group [navigateToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Assert Category 5 URL path on the 'EN' store view after change parent category");
		$I->comment("Entering Action Group [goToCategory5Page] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoToCategory5Page
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToCategory5Page
		$I->moveMouseOver("//nav//a[span[contains(., 'EN 2')]]"); // stepKey: toCategoryGoToCategory5Page
		$I->waitForPageLoad(30); // stepKey: toCategoryGoToCategory5PageWaitForPageLoad
		$I->click("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: openSubCategoryGoToCategory5Page
		$I->waitForPageLoad(30); // stepKey: openSubCategoryGoToCategory5PageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoToCategory5Page
		$I->comment("Exiting Action Group [goToCategory5Page] StorefrontGoToSubCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertUrlPathForCategory5AfterChangeParent] StorefrontAssertProperUrlIsShownActionGroup");
		$I->seeInCurrentUrl($I->retrieveEntityField('createCategory2', 'name_lwr', 'test') . "/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: checkUrlAssertUrlPathForCategory5AfterChangeParent
		$I->comment("Exiting Action Group [assertUrlPathForCategory5AfterChangeParent] StorefrontAssertProperUrlIsShownActionGroup");
	}
}
