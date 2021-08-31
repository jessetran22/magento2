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
 * @Title("MAGETWO-94934: Rewriting Store-level URL key of child category")
 * @Description("Rewriting Store-level URL key of child category<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/RewriteStoreLevelUrlKeyOfChildCategoryTest.xml<br>")
 * @TestCaseId("MAGETWO-94934")
 * @group CatalogUrlRewrite
 */
class RewriteStoreLevelUrlKeyOfChildCategoryTestCest
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
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
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
		$I->createEntity("defaultCategory", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory
		$I->createEntity("subCategory", "hook", "SubCategoryWithParent", ["defaultCategory"], []); // stepKey: subCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "store" . msq("customStore")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("subCategory", "hook"); // stepKey: deleteSubCategory
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteNewRootCategory
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
	 * @Stories({"MAGETWO-91649: #13513: Magento ignore store-level url_key of child category in URL rewrite process for global scope"})
	 * @Features({"CatalogUrlRewrite"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function RewriteStoreLevelUrlKeyOfChildCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('subCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedSubCategory
		$I->comment("Exiting Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [AdminSwitchStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownAdminSwitchStoreViewForSubCategory
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchStoreViewForSubCategoryWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'store" . msq("customStore") . "')]"); // stepKey: clickStoreViewByNameAdminSwitchStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameAdminSwitchStoreViewForSubCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchStoreViewForSubCategoryWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchStoreViewForSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedAdminSwitchStoreViewForSubCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherAdminSwitchStoreViewForSubCategory
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewNameAdminSwitchStoreViewForSubCategory
		$I->comment("Exiting Action Group [AdminSwitchStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForSubCategory] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForSubCategory
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyForSubCategory
		$I->fillField("input[name='url_key']", "bags-second"); // stepKey: enterURLKeyChangeSeoUrlKeyForSubCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForSubCategory
		$I->comment("Exiting Action Group [changeSeoUrlKeyForSubCategory] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->comment("Entering Action Group [navigateToCreatedDefaultCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedDefaultCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedDefaultCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('defaultCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedDefaultCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedDefaultCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedDefaultCategory
		$I->comment("Exiting Action Group [navigateToCreatedDefaultCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForDefaultCategory] ChangeSeoUrlKeyActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForDefaultCategory
		$I->fillField("input[name='url_key']", "gear-global"); // stepKey: enterURLKeyChangeSeoUrlKeyForDefaultCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForDefaultCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForDefaultCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForDefaultCategory
		$I->comment("Exiting Action Group [changeSeoUrlKeyForDefaultCategory] ChangeSeoUrlKeyActionGroup");
		$I->comment("Entering Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPage
		$I->comment("Exiting Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [storefrontSwitchStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherStorefrontSwitchStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownStorefrontSwitchStoreView
		$I->click("li.view-store" . msq("customStore") . ">a"); // stepKey: clickSelectStoreViewStorefrontSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStorefrontSwitchStoreView
		$I->comment("Exiting Action Group [storefrontSwitchStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [goToSubCategoryPage] GoToSubCategoryPageActionGroup");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('defaultCategory', 'name', 'test') . "')]]"); // stepKey: moveMouseOnMainCategoryGoToSubCategoryPage
		$I->waitForPageLoad(30); // stepKey: moveMouseOnMainCategoryGoToSubCategoryPageWaitForPageLoad
		$I->waitForElementVisible("//nav//a[span[contains(., '" . $I->retrieveEntityField('subCategory', 'name', 'test') . "')]]", 30); // stepKey: waitForSubCategoryVisibleGoToSubCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForSubCategoryVisibleGoToSubCategoryPageWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('subCategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryGoToSubCategoryPage
		$I->waitForPageLoad(30); // stepKey: goToCategoryGoToSubCategoryPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToSubCategoryPage
		$I->seeInCurrentUrl("gear-global/bags-second.html"); // stepKey: checkUrlGoToSubCategoryPage
		$I->seeInTitle($I->retrieveEntityField('subCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleGoToSubCategoryPage
		$I->see($I->retrieveEntityField('subCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameGoToSubCategoryPage
		$I->comment("Exiting Action Group [goToSubCategoryPage] GoToSubCategoryPageActionGroup");
	}
}
