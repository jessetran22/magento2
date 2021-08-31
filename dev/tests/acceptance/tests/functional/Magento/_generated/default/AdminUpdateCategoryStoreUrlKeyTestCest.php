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
 * @Title("MAGETWO-92338: SEO-friendly URL should update regardless of scope or redirect change.")
 * @Description("SEO-friendly URL should update regardless of scope or redirect change.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateCategoryStoreUrlKeyTest.xml<br>")
 * @TestCaseId("MAGETWO-92338")
 * @group category
 */
class AdminUpdateCategoryStoreUrlKeyTestCest
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
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Update SEO-friendly URL via the Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateCategoryStoreUrlKeyTest(AcceptanceTester $I)
	{
		$I->comment("Create category, change store view to default");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [createCategory] CreateCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateCategory
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateCategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateCategory
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: enterCategoryNameCreateCategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateCategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateCategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplecategory" . msq("_defaultCategory")); // stepKey: enterURLKeyCreateCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateCategory
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeNewCategoryPageTitleCreateCategory
		$I->seeElement("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: seeCategoryInTreeCreateCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createCategory] CreateCategoryActionGroup");
		$I->comment("Switch to \"Default Store View\" scope");
		$I->comment("Entering Action Group [SwitchStoreView] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1SwitchStoreView
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: navigateToCreatedCategorySwitchStoreView
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategorySwitchStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2SwitchStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerSwitchStoreView
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleSwitchStoreView
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownSwitchStoreView
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='Default Store View']"); // stepKey: selectStoreViewSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3SwitchStoreView
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2SwitchStoreView
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadSwitchStoreView
		$I->comment("Exiting Action Group [SwitchStoreView] SwitchCategoryStoreViewActionGroup");
		$I->comment("See \"Use Default Value\" checkboxes");
		$I->seeElement("input[name='use_default[is_active]']"); // stepKey: seeUseDefaultEnable
		$I->seeElement("input[name='use_default[include_in_menu]']"); // stepKey: seeUseDefaultMenu
		$I->seeElement("input[name='use_default[name]']"); // stepKey: seeUseDefaultName
		$I->comment("Update SEO key, uncheck \"Create Redirect\", confirm in frontend");
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSeoSection
		$I->waitForPageLoad(30); // stepKey: openSeoSectionWaitForPageLoad
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckUseDefaultUrlKey
		$I->fillField("input[name='url_key']", "simplecategory" . msq("_defaultCategory") . "-hattest"); // stepKey: enterURLKey
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirect1
		$I->comment("Entering Action Group [saveCategoryAfterFirstSeoUpdate] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategoryAfterFirstSeoUpdate
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryAfterFirstSeoUpdateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategoryAfterFirstSeoUpdate
		$I->comment("Exiting Action Group [saveCategoryAfterFirstSeoUpdate] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessage
		$I->amOnPage(""); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForFrontendLoad
		$I->click("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: clickCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryWaitForPageLoad
		$I->see("simpleCategory" . msq("_defaultCategory"), "#page-title-heading span"); // stepKey: assertCategoryOnStorefront
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeCategoryNameInTitle
		$I->seeInCurrentUrl("simplecategory" . msq("_defaultCategory") . "-hattest.html"); // stepKey: verifyUrlKey
		$I->comment("Update SEO key to original, uncheck \"Create Redirect\", confirm in frontend, delete category");
		$I->comment("Switch to \"Default Store View\" scope");
		$I->comment("Entering Action Group [SwitchStoreView2] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageSwitchStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1SwitchStoreView2
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: navigateToCreatedCategorySwitchStoreView2
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategorySwitchStoreView2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2SwitchStoreView2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerSwitchStoreView2
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleSwitchStoreView2
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownSwitchStoreView2
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='Default Store View']"); // stepKey: selectStoreViewSwitchStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3SwitchStoreView2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2SwitchStoreView2
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptSwitchStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadSwitchStoreView2
		$I->comment("Exiting Action Group [SwitchStoreView2] SwitchCategoryStoreViewActionGroup");
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSeoSection2
		$I->waitForPageLoad(30); // stepKey: openSeoSection2WaitForPageLoad
		$I->fillField("input[name='url_key']", "simplecategory" . msq("_defaultCategory")); // stepKey: enterOriginalURLKey
		$I->uncheckOption("[data-index='url_key_create_redirect'] input[type='checkbox']"); // stepKey: uncheckRedirect2
		$I->comment("Entering Action Group [saveCategoryAfterOriginalSeoKey] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategoryAfterOriginalSeoKey
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryAfterOriginalSeoKeyWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategoryAfterOriginalSeoKey
		$I->comment("Exiting Action Group [saveCategoryAfterOriginalSeoKey] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageAfterOriginalSeoKey
		$I->amOnPage(""); // stepKey: goToStorefrontAfterOriginalSeoKey
		$I->waitForPageLoad(30); // stepKey: waitForFrontendLoadAfterOriginalSeoKey
		$I->click("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: clickCategoryAfterOriginalSeoKey
		$I->waitForPageLoad(30); // stepKey: clickCategoryAfterOriginalSeoKeyWaitForPageLoad
		$I->see("simpleCategory" . msq("_defaultCategory"), "#page-title-heading span"); // stepKey: assertCategoryOnStorefront2
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeCategoryNameInTitle2
		$I->seeInCurrentUrl("simplecategory" . msq("_defaultCategory") . ".html"); // stepKey: verifyUrlKeyAfterOriginalSeoKey
	}
}
