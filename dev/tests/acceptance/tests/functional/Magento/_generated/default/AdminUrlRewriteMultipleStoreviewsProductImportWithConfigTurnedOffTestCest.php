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
 * @Title("MC-6802: Url Rewrites Correctly Generated for Multiple Storeviews During Product Import With Configuration Turned Off")
 * @Description("Check Url Rewrites Correctly Generated for Multiple Storeviews During Product Import.<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminCheckUrlRewritesCorrectlyGeneratedForMultipleStoreviewsDuringProductImportTest/AdminUrlRewriteMultipleStoreviewsProductImportWithConfigTurnedOffTest.xml<br>")
 * @TestCaseId("MC-6802")
 * @group urlRewrite
 */
class AdminUrlRewriteMultipleStoreviewsProductImportWithConfigTurnedOffTestCest
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
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites to Yes (default)");
		$I->comment("Enable SEO configuration setting to generate category/product URL Rewrites");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$createCategoryFields['name'] = "category-admin";
		$I->createEntity("createCategory", "hook", "ApiCategory", [], $createCategoryFields); // stepKey: createCategory
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create Store View EN");
		$I->comment("Entering Action Group [createStoreViewEn] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewEn
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreViewEn
		$I->fillField("#store_name", "EN"); // stepKey: enterStoreViewNameCreateStoreViewEn
		$I->fillField("#store_code", "en"); // stepKey: enterStoreViewCodeCreateStoreViewEn
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewEn
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewEn
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewEnWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewEn
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewEnWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewEn
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewEn
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewEnWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewEn
		$I->comment("Exiting Action Group [createStoreViewEn] AdminCreateStoreViewActionGroup");
		$I->comment("Create Store View NL");
		$I->comment("Entering Action Group [createStoreViewNl] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewNl
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewNl
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreViewNl
		$I->fillField("#store_name", "NL"); // stepKey: enterStoreViewNameCreateStoreViewNl
		$I->fillField("#store_code", "nl"); // stepKey: enterStoreViewCodeCreateStoreViewNl
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewNl
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewNl
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewNlWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewNl
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewNlWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewNl
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewNl
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewNlWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewNl
		$I->comment("Exiting Action Group [createStoreViewNl] AdminCreateStoreViewActionGroup");
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites to No");
		$I->comment("Disable SEO configuration setting to generate category/product URL Rewrites");
		$disableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 0", 60); // stepKey: disableGenerateUrlRewrite
		$I->comment($disableGenerateUrlRewrite);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteStoreViewEn] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreViewEn
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewEnWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN"); // stepKey: fillStoreViewFilterFieldDeleteStoreViewEn
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewEnWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewEnWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreViewEn
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewEnWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreViewEn
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewEn
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewEnWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreViewEn
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreViewEn
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewEnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreViewEn
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreViewEn
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreViewEn
		$I->comment("Exiting Action Group [deleteStoreViewEn] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [deleteStoreViewNl] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreViewNl
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreViewNl
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreViewNl
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewNlWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "NL"); // stepKey: fillStoreViewFilterFieldDeleteStoreViewNl
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewNlWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreViewNl
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewNlWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreViewNl
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreViewNl
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreViewNl
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewNlWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreViewNl
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewNl
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewNlWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreViewNl
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreViewNl
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewNlWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreViewNl
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreViewNl
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreViewNl
		$I->comment("Exiting Action Group [deleteStoreViewNl] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [clearStoreGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearStoreGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearStoreGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearStoreGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteImportedProduct] DeleteProductByNameActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteImportedProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteImportedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteImportedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteImportedProduct
		$I->fillField("input.admin__control-text[name='name']", "productformagetwo68980"); // stepKey: fillProductSkuFilterDeleteImportedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteImportedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteImportedProductWaitForPageLoad
		$I->see("productformagetwo68980", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridDeleteImportedProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteImportedProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteImportedProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteImportedProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteImportedProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteImportedProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteImportedProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteImportedProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteImportedProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteImportedProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteImportedProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteImportedProduct
		$I->comment("Exiting Action Group [deleteImportedProduct] DeleteProductByNameActionGroup");
		$I->comment("Entering Action Group [clearFiltersIfSet] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersIfSet
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersIfSetWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersIfSet] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$resetConfigurationSetting = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: resetConfigurationSetting
		$I->comment($resetConfigurationSetting);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"UrlRewrite"})
	 * @Stories({"Url Rewrites for Multiple Storeviews"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUrlRewriteMultipleStoreviewsProductImportWithConfigTurnedOffTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [switchToStoreViewEn] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageSwitchToStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1SwitchToStoreViewEn
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: navigateToCreatedCategorySwitchToStoreViewEn
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategorySwitchToStoreViewEnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2SwitchToStoreViewEn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerSwitchToStoreViewEn
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleSwitchToStoreViewEn
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownSwitchToStoreViewEn
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='EN']"); // stepKey: selectStoreViewSwitchToStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3SwitchToStoreViewEn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2SwitchToStoreViewEn
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptSwitchToStoreViewEn
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadSwitchToStoreViewEn
		$I->comment("Exiting Action Group [switchToStoreViewEn] SwitchCategoryStoreViewActionGroup");
		$I->comment("Entering Action Group [changeCategoryNameForENStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckUseDefaultValueENStoreViewChangeCategoryNameForENStoreView
		$I->fillField("input[name='name']", "categoryenglish"); // stepKey: changeNameFieldChangeCategoryNameForENStoreView
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: clickOnSectionHeaderChangeCategoryNameForENStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnSectionHeaderChangeCategoryNameForENStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [changeCategoryNameForENStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyENStoreView] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyENStoreView
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyENStoreView
		$I->fillField("input[name='url_key']", "category-english"); // stepKey: enterURLKeyChangeSeoUrlKeyENStoreView
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyENStoreView
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyENStoreViewWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyENStoreView
		$I->comment("Exiting Action Group [changeSeoUrlKeyENStoreView] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->comment("Entering Action Group [switchToStoreViewNl] SwitchCategoryStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageSwitchToStoreViewNl
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1SwitchToStoreViewNl
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: navigateToCreatedCategorySwitchToStoreViewNl
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategorySwitchToStoreViewNlWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2SwitchToStoreViewNl
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerSwitchToStoreViewNl
		$I->scrollToTopOfPage(); // stepKey: scrollToToggleSwitchToStoreViewNl
		$I->click("#store-change-button"); // stepKey: openStoreViewDropDownSwitchToStoreViewNl
		$I->click("//div[contains(@class, 'store-switcher')]//a[normalize-space()='NL']"); // stepKey: selectStoreViewSwitchToStoreViewNl
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3SwitchToStoreViewNl
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinner2SwitchToStoreViewNl
		$I->click(".modal-popup.confirm._show .action-accept"); // stepKey: selectStoreViewAcceptSwitchToStoreViewNl
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewChangeLoadSwitchToStoreViewNl
		$I->comment("Exiting Action Group [switchToStoreViewNl] SwitchCategoryStoreViewActionGroup");
		$I->comment("Entering Action Group [changeCategoryNameForNLStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->uncheckOption("input[name='use_default[name]']"); // stepKey: uncheckUseDefaultValueENStoreViewChangeCategoryNameForNLStoreView
		$I->fillField("input[name='name']", "categorydutch"); // stepKey: changeNameFieldChangeCategoryNameForNLStoreView
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: clickOnSectionHeaderChangeCategoryNameForNLStoreView
		$I->waitForPageLoad(30); // stepKey: clickOnSectionHeaderChangeCategoryNameForNLStoreViewWaitForPageLoad
		$I->comment("Exiting Action Group [changeCategoryNameForNLStoreView] AdminChangeCategoryNameOnStoreViewLevelActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyNLStoreView] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyNLStoreView
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyNLStoreView
		$I->fillField("input[name='url_key']", "category-dutch"); // stepKey: enterURLKeyChangeSeoUrlKeyNLStoreView
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyNLStoreView
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyNLStoreViewWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyNLStoreView
		$I->comment("Exiting Action Group [changeSeoUrlKeyNLStoreView] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->comment("Import products with add/update behavior");
		$I->comment("Entering Action Group [importProduct] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageImportProduct
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadImportProduct
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionImportProduct
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleImportProduct
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionImportProduct
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionImportProduct
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldImportProduct
		$I->attachFile("#import_file", "import_updated.csv"); // stepKey: attachFileForImportImportProduct
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonImportProduct
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonImportProductWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForValidationNoticeMessageImportProduct
		$I->see("Checked rows: 3, checked entities: 1, invalid rows: 0, total errors: 0", "#import_validation_messages .message-notice"); // stepKey: seeValidationNoticeMessageImportProduct
		$I->see("File is valid! To start import process press \"Import\" button", "#import_validation_messages .message-success"); // stepKey: seeValidationMessageImportProduct
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonImportProduct
		$I->waitForPageLoad(30); // stepKey: clickImportButtonImportProductWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageImportProduct
		$I->see("Created: 1, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageImportProduct
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageImportProduct
		$I->comment("Exiting Action Group [importProduct] AdminImportProductsWithCheckValidationResultActionGroup");
		$I->comment("Filter Product in product page and get the Product ID");
		$I->comment("Entering Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", "productformagetwo68980"); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='productformagetwo68980']]"); // stepKey: openSelectedProductFilterProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterAndSelectProductActionGroup");
		$grabProductIdFromUrl = $I->grabFromCurrentUrl("~/id/(\d+)/~"); // stepKey: grabProductIdFromUrl
		$I->comment("Open Marketing - SEO & Search - URL Rewrites");
		$I->comment("Entering Action Group [searchingCategoryUrlRewriteForENStoreView] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingCategoryUrlRewriteForENStoreView
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingCategoryUrlRewriteForENStoreView
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingCategoryUrlRewriteForENStoreView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingCategoryUrlRewriteForENStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingCategoryUrlRewriteForENStoreView
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingCategoryUrlRewriteForENStoreView
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingCategoryUrlRewriteForENStoreViewWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "category-english.html"); // stepKey: fillRequestPathFilterSearchingCategoryUrlRewriteForENStoreView
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingCategoryUrlRewriteForENStoreView
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingCategoryUrlRewriteForENStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingCategoryUrlRewriteForENStoreView
		$I->comment("Exiting Action Group [searchingCategoryUrlRewriteForENStoreView] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeUrlInRequestPathColumnForENStoreView] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='category-english.html']"); // stepKey: seeValueInGridSeeUrlInRequestPathColumnForENStoreView
		$I->comment("Exiting Action Group [seeUrlInRequestPathColumnForENStoreView] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeUrlInTargetPathColumnForENStoreView] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1][normalize-space(.)='catalog/category/view/id/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "']"); // stepKey: seeValueInGridSeeUrlInTargetPathColumnForENStoreView
		$I->comment("Exiting Action Group [seeUrlInTargetPathColumnForENStoreView] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [searchingCategoryUrlRewriteForNLStoreView] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingCategoryUrlRewriteForNLStoreView
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingCategoryUrlRewriteForNLStoreView
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingCategoryUrlRewriteForNLStoreView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingCategoryUrlRewriteForNLStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingCategoryUrlRewriteForNLStoreView
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingCategoryUrlRewriteForNLStoreView
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingCategoryUrlRewriteForNLStoreViewWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "category-dutch.html"); // stepKey: fillRequestPathFilterSearchingCategoryUrlRewriteForNLStoreView
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingCategoryUrlRewriteForNLStoreView
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingCategoryUrlRewriteForNLStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingCategoryUrlRewriteForNLStoreView
		$I->comment("Exiting Action Group [searchingCategoryUrlRewriteForNLStoreView] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeUrlInRequestPathColumnForNLStoreView] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='category-dutch.html']"); // stepKey: seeValueInGridSeeUrlInRequestPathColumnForNLStoreView
		$I->comment("Exiting Action Group [seeUrlInRequestPathColumnForNLStoreView] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeUrlInTargetPathColumnForNLStoreView] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1][normalize-space(.)='catalog/category/view/id/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "']"); // stepKey: seeValueInGridSeeUrlInTargetPathColumnForNLStoreView
		$I->comment("Exiting Action Group [seeUrlInTargetPathColumnForNLStoreView] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [searchingProductUrl] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingProductUrl
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingProductUrl
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingProductUrl
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingProductUrlWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingProductUrl
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingProductUrl
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingProductUrlWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "productformagetwo68980-english.html"); // stepKey: fillRequestPathFilterSearchingProductUrl
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingProductUrl
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingProductUrlWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingProductUrl
		$I->comment("Exiting Action Group [searchingProductUrl] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeRequestPathForProduct] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='productformagetwo68980-english.html']"); // stepKey: seeValueInGridSeeRequestPathForProduct
		$I->comment("Exiting Action Group [seeRequestPathForProduct] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeTargetPathForProduct] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1][normalize-space(.)='catalog/product/view/id/$grabProductIdFromUrl']"); // stepKey: seeValueInGridSeeTargetPathForProduct
		$I->comment("Exiting Action Group [seeTargetPathForProduct] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeRequestPathForENStoreView] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='category-english/productformagetwo68980-english.html']"); // stepKey: valueIsNotShownInGridDoNotSeeRequestPathForENStoreView
		$I->comment("Exiting Action Group [doNotSeeRequestPathForENStoreView] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeTargetPathForENStoreView] AssertAdminTargetPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='catalog/product/view/id/$grabProductIdFromUrl/category/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "']"); // stepKey: valueIsNotShownInGridDoNotSeeTargetPathForENStoreView
		$I->comment("Exiting Action Group [doNotSeeTargetPathForENStoreView] AssertAdminTargetPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [searchingProductUrlForNLStoreView] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingProductUrlForNLStoreView
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingProductUrlForNLStoreView
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingProductUrlForNLStoreView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingProductUrlForNLStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingProductUrlForNLStoreView
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingProductUrlForNLStoreView
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingProductUrlForNLStoreViewWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", "productformagetwo68980-dutch.html"); // stepKey: fillRequestPathFilterSearchingProductUrlForNLStoreView
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingProductUrlForNLStoreView
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingProductUrlForNLStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingProductUrlForNLStoreView
		$I->comment("Exiting Action Group [searchingProductUrlForNLStoreView] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeRequestPathForProductForNLStoreView] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='productformagetwo68980-dutch.html']"); // stepKey: seeValueInGridSeeRequestPathForProductForNLStoreView
		$I->comment("Exiting Action Group [seeRequestPathForProductForNLStoreView] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeTargetPathForProductForNLStoreView] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Target Path')]/preceding-sibling::th)+1][normalize-space(.)='catalog/product/view/id/$grabProductIdFromUrl']"); // stepKey: seeValueInGridSeeTargetPathForProductForNLStoreView
		$I->comment("Exiting Action Group [seeTargetPathForProductForNLStoreView] AssertAdminTargetPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeRequestPathForNLStoreView] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='category-dutch/productformagetwo68980-dutch.html']"); // stepKey: valueIsNotShownInGridDoNotSeeRequestPathForNLStoreView
		$I->comment("Exiting Action Group [doNotSeeRequestPathForNLStoreView] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [doNotSeeTargetPathForNLStoreView] AssertAdminTargetPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='catalog/product/view/id/$grabProductIdFromUrl/category/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "']"); // stepKey: valueIsNotShownInGridDoNotSeeTargetPathForNLStoreView
		$I->comment("Exiting Action Group [doNotSeeTargetPathForNLStoreView] AssertAdminTargetPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->comment("Switch StoreView");
		$I->comment("Entering Action Group [amOnStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStoreFrontHomePage
		$I->comment("Exiting Action Group [amOnStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreView
		$I->click("li.view-en>a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Assert Redirects work and Product is present on StoreFront");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/productformagetwo68980-english.html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPage
		$I->see("productformagetwo68980-english", ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPage
		$I->see("productformagetwo68980", ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPage
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPage] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageSecondAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/category-english/productformagetwo68980-english.html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageSecondAttempt
		$I->see("productformagetwo68980-english", ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageSecondAttempt
		$I->see("productformagetwo68980", ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageSecondAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageSecondAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Switch StoreView");
		$I->comment("Entering Action Group [backToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageBackToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadBackToHomePage
		$I->comment("Exiting Action Group [backToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [switchToCustomStoreView2] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToCustomStoreView2
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToCustomStoreView2
		$I->click("li.view-nl>a"); // stepKey: clickSelectStoreViewSwitchToCustomStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView2
		$I->comment("Exiting Action Group [switchToCustomStoreView2] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Assert Redirects work and Product is present on StoreFront");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageThirdAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/productformagetwo68980-dutch.html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageThirdAttempt
		$I->see("productformagetwo68980-dutch", ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageThirdAttempt
		$I->see("productformagetwo68980", ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageThirdAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageThirdAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->comment("Entering Action Group [verifyProductInStoreFrontPageFourthAttempt] AssertStorefrontProductRedirectActionGroup");
		$I->amOnPage("/category-dutch/productformagetwo68980-dutch.html"); // stepKey: openCategoryInStorefrontVerifyProductInStoreFrontPageFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadVerifyProductInStoreFrontPageFourthAttempt
		$I->see("productformagetwo68980-dutch", ".base"); // stepKey: seeProductNameInStoreFrontPageVerifyProductInStoreFrontPageFourthAttempt
		$I->see("productformagetwo68980", ".product.attribute.sku>.value"); // stepKey: seeProductSkuInStoreFrontPageVerifyProductInStoreFrontPageFourthAttempt
		$I->comment("Exiting Action Group [verifyProductInStoreFrontPageFourthAttempt] AssertStorefrontProductRedirectActionGroup");
	}
}
