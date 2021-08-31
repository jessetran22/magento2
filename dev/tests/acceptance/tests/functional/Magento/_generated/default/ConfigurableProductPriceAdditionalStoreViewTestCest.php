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
 * @Title("MC-25761: Configurable product prices should not disappear on storefront for additional store")
 * @Description("Configurable product price should not disappear for additional stores on frontEnd if disabled for default store<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/ConfigurableProductPriceAdditionalStoreViewTest.xml<br>")
 * @TestCaseId("MC-25761")
 * @group ConfigurableProduct
 */
class ConfigurableProductPriceAdditionalStoreViewTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1", "createCategory"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2", "createCategory"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddStoreCodeToUrls
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: expandUrlSectionTabAddStoreCodeToUrls
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrlAddStoreCodeToUrls
		$I->uncheckOption("#web_url_use_store_inherit"); // stepKey: uncheckUseSystemValueAddStoreCodeToUrls
		$I->selectOption("#web_url_use_store", "Yes"); // stepKey: enableStoreCodeAddStoreCodeToUrls
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsAddStoreCodeToUrls
		$I->click("#save"); // stepKey: saveConfigAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: saveConfigAddStoreCodeToUrlsWaitForPageLoad
		$I->comment("Exiting Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->comment("Entering Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateAdditionalWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateAdditionalWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateAdditionalWebsite
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateAdditionalWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateAdditionalWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateAdditionalWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateAdditionalWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateAdditionalWebsite
		$I->comment("Exiting Action Group [createAdditionalWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectWebsiteCreateNewStore
		$I->fillField("#group_name", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupNameCreateNewStore
		$I->fillField("#group_code", "store" . msq("customStoreGroup")); // stepKey: enterStoreGroupCodeCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateNewStore
		$I->comment("Exiting Action Group [createNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStoreGroup")); // stepKey: selectStoreCreateNewStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateNewStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateNewStoreView
		$I->comment("Exiting Action Group [createNewStoreView] AdminCreateStoreViewActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPagetoResetResetUrlOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetUrlOption
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: closeUrlSectionTabResetUrlOption
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrl2ResetUrlOption
		$I->comment("<uncheckOption selector=\"\{\{UrlOptionsSection.systemValueForStoreCode\}\}\" stepKey=\"uncheckUseSystemValue\"/>");
		$I->selectOption("#web_url_use_store", "No"); // stepKey: enableStoreCodeResetUrlOption
		$I->checkOption("#web_url_use_store_inherit"); // stepKey: checkUseSystemValueResetUrlOption
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsResetUrlOption
		$I->click("#save"); // stepKey: saveConfigResetUrlOption
		$I->waitForPageLoad(30); // stepKey: saveConfigResetUrlOptionWaitForPageLoad
		$I->comment("Exiting Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->comment("Entering Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteSecondWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteSecondWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteSecondWebsiteWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteSecondWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteSecondWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteSecondWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteSecondWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteSecondWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteSecondWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteSecondWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteSecondWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteSecondWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSecondWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"View products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ConfigurableProductPriceAdditionalStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("go to admin and open product edit page to disable product all store view");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitEditPage
		$I->click("input[name='product[status]']+label"); // stepKey: disableProductForAllStoreView
		$I->comment("Entering Action Group [saveWithThreeOptions] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveWithThreeOptions
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveWithThreeOptions
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveWithThreeOptionsWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveWithThreeOptions
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveWithThreeOptionsWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveWithThreeOptions
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveWithThreeOptions
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveWithThreeOptions
		$I->comment("Exiting Action Group [saveWithThreeOptions] SaveProductFormActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='product[status]']"); // stepKey: dontSeeCheckboxEnableProductIsChecked
		$I->comment("Disable each of the child products for All Store views");
		$I->click("(//button[@class='action-select']/span[contains(text(), 'Select')])[1]"); // stepKey: clickToExpandActionsForFirstVariation1
		$I->click("//a[text()='Disable Product']"); // stepKey: clickDisableChildProduct1
		$I->click("(//button[@class='action-select']/span[contains(text(), 'Select')])[2]"); // stepKey: clickToExpandActionsForSecondVariation1
		$I->click("//a[text()='Disable Product']"); // stepKey: clickDisableChildProduct2
		$I->comment("Add product to second website");
		$I->click("div[data-index='websites']"); // stepKey: openProductInWebsitesSection1
		$I->waitForPageLoad(30); // stepKey: openProductInWebsitesSection1WaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectSecondWebsite
		$I->click("#save-button"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForProductPageSave
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessage
		$I->comment("switch to the second store view");
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcher
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessage
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad9
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewName
		$I->comment("enable the config product for the second store");
		$I->waitForElementVisible("input[name='use_default[status]']", 30); // stepKey: waitForDefaultValueCheckBox
		$I->click("input[name='use_default[status]']"); // stepKey: unCheckUseDefaultValueCheckBox
		$I->waitForElementVisible("input[name='product[status]']+label", 30); // stepKey: waitForProductEnableSlider
		$I->click("input[name='product[status]']+label"); // stepKey: enableProductForSecondStoreView
		$I->seeCheckboxIsChecked("input[name='product[status]']"); // stepKey: seeThatProductIsEnabled
		$I->comment("Entering Action Group [enabledConfigProductSecondStore] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownEnabledConfigProductSecondStore
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownEnabledConfigProductSecondStoreWaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseEnabledConfigProductSecondStore
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseEnabledConfigProductSecondStoreWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessEnabledConfigProductSecondStore
		$I->comment("Exiting Action Group [enabledConfigProductSecondStore] AdminFormSaveAndCloseActionGroup");
		$I->comment("go to admin and open product edit page to enable child product for second store view");
		$I->comment("Entering Action Group [goToProductEditPage2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage2
		$I->comment("Exiting Action Group [goToProductEditPage2] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitEditPage2
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcher1
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcher1WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreView1
		$I->waitForPageLoad(10); // stepKey: chooseStoreView1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessage1
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad8
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewName1
		$I->click("(//button[@class='action-select']/span[contains(text(), 'Select')])[1]"); // stepKey: clickToExpandActionsForFirstVariation2
		$I->click("//a[text()='Enable Product']"); // stepKey: clickEnableChildProduct1
		$I->click("(//button[@class='action-select']/span[contains(text(), 'Select')])[2]"); // stepKey: clickToExpandActionsForSecondVariation2
		$I->click("//a[text()='Enable Product']"); // stepKey: clickEnableChildProduct2
		$I->comment("Entering Action Group [saveAll] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAll
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAllWaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSaveAll
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSaveAllWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSaveAll
		$I->comment("Exiting Action Group [saveAll] AdminFormSaveAndCloseActionGroup");
		$I->comment("assert second store view storefront category list page");
		$I->amOnPage("/store" . msq("customStore") . "/"); // stepKey: amOnsecondStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad31
		$I->click($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: clickOnCategoryName1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad41
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: assertProductPresent1
		$I->comment("go to admin and open child product1 and assign it to the second website");
		$I->comment("Entering Action Group [goToProduct1EditPage1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductGoToProduct1EditPage1
		$I->comment("Exiting Action Group [goToProduct1EditPage1] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitChild1EditPageToLoad
		$I->click("div[data-index='websites']"); // stepKey: openProduct1InWebsitesSection
		$I->waitForPageLoad(30); // stepKey: openProduct1InWebsitesSectionWaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectSecondWebsite1
		$I->comment("Entering Action Group [saveUpdatedChild1Again] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveUpdatedChild1Again
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveUpdatedChild1AgainWaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSaveUpdatedChild1Again
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSaveUpdatedChild1AgainWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSaveUpdatedChild1Again
		$I->comment("Exiting Action Group [saveUpdatedChild1Again] AdminFormSaveAndCloseActionGroup");
		$I->comment("go to admin again and open child product1 and enable for second store view");
		$I->comment("Entering Action Group [goToProduct1EditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductGoToProduct1EditPage
		$I->comment("Exiting Action Group [goToProduct1EditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitChild1EditPageToLoad1
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherP1
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherP1WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreView2P1
		$I->waitForPageLoad(10); // stepKey: chooseStoreView2P1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageP1
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageP1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedP1
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewNameP1
		$I->waitForElementVisible("input[name='product[status]']+label", 30); // stepKey: waitForProductEnableSliderP1
		$I->seeCheckboxIsChecked("input[name='product[status]']"); // stepKey: seeThatProduct1IsEnabled
		$I->comment("Entering Action Group [save2UpdatedChild1] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSave2UpdatedChild1
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSave2UpdatedChild1WaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSave2UpdatedChild1
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSave2UpdatedChild1WaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSave2UpdatedChild1
		$I->comment("Exiting Action Group [save2UpdatedChild1] AdminFormSaveAndCloseActionGroup");
		$I->comment("go to admin and open child product2 edit page  and assign it to the second website");
		$I->comment("Entering Action Group [goToProduct2EditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: goToProductGoToProduct2EditPage
		$I->comment("Exiting Action Group [goToProduct2EditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitChild2EditPageToLoad
		$I->click("div[data-index='websites']"); // stepKey: openProduct2InWebsitesSection
		$I->waitForPageLoad(30); // stepKey: openProduct2InWebsitesSectionWaitForPageLoad
		$I->click("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectSecondWebsite2
		$I->comment("Entering Action Group [saveUpdatedChild2] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveUpdatedChild2
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveUpdatedChild2WaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSaveUpdatedChild2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSaveUpdatedChild2WaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSaveUpdatedChild2
		$I->comment("Exiting Action Group [saveUpdatedChild2] AdminFormSaveAndCloseActionGroup");
		$I->comment("go to admin again and open child product2 and enable for second store view");
		$I->comment("Entering Action Group [goToProduct2EditPage2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: goToProductGoToProduct2EditPage2
		$I->comment("Exiting Action Group [goToProduct2EditPage2] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitChild2EditPageToLoad1
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherP2
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherP2WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreView2P2
		$I->waitForPageLoad(10); // stepKey: chooseStoreView2P2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageP2
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageP2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedP2
		$I->see("store" . msq("customStore"), ".store-switcher"); // stepKey: seeNewStoreViewNameP2
		$I->waitForElementVisible("input[name='product[status]']+label", 30); // stepKey: waitForProductEnableSliderP2
		$I->seeCheckboxIsChecked("input[name='product[status]']"); // stepKey: seeThatProduct2IsEnabled
		$I->comment("Entering Action Group [save2UpdatedChild2] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSave2UpdatedChild2
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSave2UpdatedChild2WaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSave2UpdatedChild2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSave2UpdatedChild2WaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSave2UpdatedChild2
		$I->comment("Exiting Action Group [save2UpdatedChild2] AdminFormSaveAndCloseActionGroup");
		$I->comment("assert storefront category list page");
		$I->amOnPage("/store" . msq("customStore") . "/"); // stepKey: amOnsecondStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->click($I->retrieveEntityField('createCategory', 'name', 'test')); // stepKey: clickOnCategoryName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test')); // stepKey: assertProductPresent
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'price', 'test')); // stepKey: assertProductPricePresent
	}
}
