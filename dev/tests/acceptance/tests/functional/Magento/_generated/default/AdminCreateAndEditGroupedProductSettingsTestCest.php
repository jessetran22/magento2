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
 * @Title("MC-3243: Admin should be able to set/edit other product information when creating/editing a grouped product")
 * @Description("Admin should be able to set/edit other product information when creating/editing a grouped product<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdminCreateAndEditGroupedProductSettingsTest.xml<br>")
 * @TestCaseId("MC-3243")
 * @group Catalog
 */
class AdminCreateAndEditGroupedProductSettingsTestCest
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
		$I->comment("Create a Website");
		$I->createEntity("createWebsite", "hook", "customWebsite", [], []); // stepKey: createWebsite
		$I->comment("Create Simple Product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete grouped product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("groupedproduct" . msq("GroupedProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Delete Website");
		$I->comment("Entering Action Group [deleteCreatedWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteCreatedWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteCreatedWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteCreatedWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", $I->retrieveEntityField('createWebsite', 'website[name]', 'hook')); // stepKey: fillSearchWebsiteFieldDeleteCreatedWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteCreatedWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteCreatedWebsiteWaitForPageLoad
		$I->see($I->retrieveEntityField('createWebsite', 'website[name]', 'hook'), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteCreatedWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteCreatedWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteCreatedWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteCreatedWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteCreatedWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteCreatedWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteCreatedWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteCreatedWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteCreatedWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteCreatedWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteCreatedWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteCreatedWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteCreatedWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCreatedWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Delete simple product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Log out");
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"Create/Edit grouped product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateAndEditGroupedProductSettingsTest(AcceptanceTester $I)
	{
		$I->comment("Create new grouped product");
		$I->comment("Entering Action Group [createGroupedProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateGroupedProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateGroupedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateGroupedProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-grouped']"); // stepKey: clickAddProductCreateGroupedProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateGroupedProduct
		$I->comment("Exiting Action Group [createGroupedProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill all main fields");
		$I->comment("Entering Action Group [fillProductForm] FillGroupedProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillProductNameFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillGroupedProductFormActionGroup");
		$I->comment("Add simple product to the Group");
		$I->comment("Entering Action Group [addFirstSimpleToGroup] AdminAssignProductToGroupActionGroup");
		$I->scrollTo("div[data-index=grouped] .admin__collapsible-title", 0, -100); // stepKey: scrollToGroupedSectionAddFirstSimpleToGroup
		$I->conditionalClick("div[data-index=grouped] .admin__collapsible-title", "button[data-index='grouped_products_button']", false); // stepKey: openGroupedProductsSectionAddFirstSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: openGroupedProductsSectionAddFirstSimpleToGroupWaitForPageLoad
		$I->click("button[data-index='grouped_products_button']"); // stepKey: clickAddProductsToGroupAddFirstSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToGroupAddFirstSimpleToGroupWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-reset']", ".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersAddFirstSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersAddFirstSimpleToGroupWaitForPageLoad
		$I->click(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-expand']"); // stepKey: showFiltersPanelAddFirstSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: showFiltersPanelAddFirstSimpleToGroupWaitForPageLoad
		$I->fillField(".product_form_product_form_grouped_grouped_products_modal [name='name']", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: fillNameFilterAddFirstSimpleToGroup
		$I->click(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddFirstSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddFirstSimpleToGroupWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: selectProductAddFirstSimpleToGroup
		$I->click(".product_form_product_form_grouped_grouped_products_modal button.action-primary"); // stepKey: clickAddSelectedGroupProductsAddFirstSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedGroupProductsAddFirstSimpleToGroupWaitForPageLoad
		$I->comment("Exiting Action Group [addFirstSimpleToGroup] AdminAssignProductToGroupActionGroup");
		$I->comment("Set product in created Website");
		$I->comment("Entering Action Group [selectProductInWebsites] AdminAssignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionSelectProductInWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionSelectProductInWebsites
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectProductInWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectProductInWebsites
		$I->checkOption("//label[contains(text(), '" . $I->retrieveEntityField('createWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectProductInWebsites
		$I->comment("Exiting Action Group [selectProductInWebsites] AdminAssignProductInWebsiteActionGroup");
		$I->comment("Set Design settings for the product");
		$I->comment("Entering Action Group [setProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabSetProductDesignSettings
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenSetProductDesignSettings
		$I->selectOption("select[name='product[page_layout]']", "2 columns with left bar"); // stepKey: setLayoutSetProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Product Info Column"); // stepKey: setDisplayProductOptionsSetProductDesignSettings
		$I->comment("Exiting Action Group [setProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->comment("Save grouped product form");
		$I->comment("Entering Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveButton
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveButtonWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveButton
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveButton
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] SaveProductFormActionGroup");
		$I->comment("Open created simple product");
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenSimpleProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenSimpleProduct
		$I->comment("Exiting Action Group [openSimpleProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Set Gift Options settings for the simple product");
		$I->comment("Entering Action Group [enableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->click("div[data-index='gift-options']"); // stepKey: clickToExpandGiftOptionsTabEnableGiftMessageSettings
		$I->waitForPageLoad(30); // stepKey: waitForGiftOptionsOpenEnableGiftMessageSettings
		$I->uncheckOption("[name='product[use_config_gift_message_available]']"); // stepKey: uncheckConfigSettingsMessageEnableGiftMessageSettings
		$I->click("input[name='product[gift_message_available]']+label"); // stepKey: clickToGiftMessageSwitcherEnableGiftMessageSettings
		$I->waitForElementVisible("input[name='product[gift_message_available]'][value='1']", 30); // stepKey: assertGiftMessageStatusEnableGiftMessageSettings
		$I->comment("Exiting Action Group [enableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->comment("Save simple product form");
		$I->comment("Entering Action Group [clickSaveBtn] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveBtn
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveBtn
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveBtnWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveBtn
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveBtnWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveBtn
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveBtn
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveBtn
		$I->comment("Exiting Action Group [clickSaveBtn] SaveProductFormActionGroup");
		$I->comment("Open grouped product page");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/groupedproduct" . msq("GroupedProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert product design settings \"left bar is present at product page with 2 columns\"");
		$I->seeElement(".page-layout-2columns-left"); // stepKey: seeDesignChanges
		$I->comment("Fill product quantity");
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillFieldQtyInput
		$I->waitForPageLoad(30); // stepKey: fillFieldQtyInputWaitForPageLoad
		$I->comment("Assert Gift Option product settings is present");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage6] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage6
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage6WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage6
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage6
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage6
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage6
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage6
		$I->see("You added GroupedProduct" . msq("GroupedProduct") . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage6
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage6] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenShoppingCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenShoppingCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenShoppingCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [assertGiftMessageFieldsArePresent] StorefrontAssertGiftMessageFieldsActionGroup");
		$I->waitForElementVisible(".action.action-gift", 30); // stepKey: waitForCartGiftOptionVisibleAssertGiftMessageFieldsArePresent
		$I->click(".action.action-gift"); // stepKey: clickGiftOptionBtnAssertGiftMessageFieldsArePresent
		$I->seeElement(".gift-options-content .field-to input"); // stepKey: seeFieldToAssertGiftMessageFieldsArePresent
		$I->seeElement(".gift-options-content .field-from input"); // stepKey: seeFieldFromAssertGiftMessageFieldsArePresent
		$I->seeElement("#gift-message-whole-message"); // stepKey: seeMessageAreaAssertGiftMessageFieldsArePresent
		$I->seeElement(".action-update"); // stepKey: seeUpdateButtonAssertGiftMessageFieldsArePresent
		$I->seeElement(".action-cancel"); // stepKey: seeCancelButtonAssertGiftMessageFieldsArePresent
		$I->comment("Exiting Action Group [assertGiftMessageFieldsArePresent] StorefrontAssertGiftMessageFieldsActionGroup");
		$I->comment("Open created grouped product");
		$I->comment("Entering Action Group [searchForCreatedProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForCreatedProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForCreatedProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForCreatedProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForCreatedProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForCreatedProductWaitForPageLoad
		$I->fillField("input[name=sku]", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillSkuFieldOnFiltersSectionSearchForCreatedProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForCreatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForCreatedProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='groupedproduct" . msq("GroupedProduct") . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", "groupedproduct" . msq("GroupedProduct")); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Edit product Search Engine Optimization settings");
		$I->comment("Entering Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettings
		$I->waitForPageLoad(30); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettingsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductSEOSettings
		$I->fillField("input[name='product[url_key]']", "Api Grouped Product" . msq("ApiGroupedProduct")); // stepKey: setUrlKeyInputEditProductSEOSettings
		$I->fillField("input[name='product[meta_title]']", "Api Grouped Product" . msq("ApiGroupedProduct")); // stepKey: setMetaTitleInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_keyword]']", "Api Grouped Product" . msq("ApiGroupedProduct")); // stepKey: setMetaKeywordsInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_description]']", "Api Grouped Product" . msq("ApiGroupedProduct")); // stepKey: setMetaDescriptionInputEditProductSEOSettings
		$I->comment("Exiting Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->comment("Assert product is assigned to websites");
		$I->comment("Entering Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: scrollToProductInWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "[data-index='websites']._show", false); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsChecked
		$I->waitForPageLoad(30); // stepKey: expandProductWebsitesSectionSeeCustomWebsiteIsCheckedWaitForPageLoad
		$I->seeCheckboxIsChecked("//label[contains(text(), '" . $I->retrieveEntityField('createWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: seeCustomWebsiteIsCheckedSeeCustomWebsiteIsChecked
		$I->comment("Exiting Action Group [seeCustomWebsiteIsChecked] AssertProductIsAssignedToWebsiteActionGroup");
		$I->comment("Edit product in Websites");
		$I->comment("Entering Action Group [uncheckProductInWebsites] AdminUnassignProductInWebsiteActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSectionUncheckProductInWebsites
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSectionUncheckProductInWebsitesWaitForPageLoad
		$I->click("div[data-index='websites']"); // stepKey: expandSectionUncheckProductInWebsites
		$I->waitForPageLoad(30); // stepKey: expandSectionUncheckProductInWebsitesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedUncheckProductInWebsites
		$I->uncheckOption("//label[contains(text(), '" . $I->retrieveEntityField('createWebsite', 'website[name]', 'test') . "')]/parent::div//input[@type='checkbox']"); // stepKey: uncheckWebsiteUncheckProductInWebsites
		$I->comment("Exiting Action Group [uncheckProductInWebsites] AdminUnassignProductInWebsiteActionGroup");
		$I->comment("Edit Design settings for the product");
		$I->comment("Entering Action Group [editProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabEditProductDesignSettings
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductDesignSettings
		$I->selectOption("select[name='product[page_layout]']", "2 columns with right bar"); // stepKey: setLayoutEditProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Block after Info Column"); // stepKey: setDisplayProductOptionsEditProductDesignSettings
		$I->comment("Exiting Action Group [editProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->comment("Save grouped product form");
		$I->comment("Entering Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->comment("Open created simple product");
		$I->comment("Entering Action Group [searchForProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenProduct
		$I->comment("Exiting Action Group [openProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Edit Gift Option product settings");
		$I->comment("Entering Action Group [disableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->click("div[data-index='gift-options']"); // stepKey: clickToExpandGiftOptionsTabDisableGiftMessageSettings
		$I->waitForPageLoad(30); // stepKey: waitForGiftOptionsOpenDisableGiftMessageSettings
		$I->uncheckOption("[name='product[use_config_gift_message_available]']"); // stepKey: uncheckConfigSettingsMessageDisableGiftMessageSettings
		$I->click("input[name='product[gift_message_available]']+label"); // stepKey: clickToGiftMessageSwitcherDisableGiftMessageSettings
		$I->waitForElementVisible("input[name='product[gift_message_available]'][value='0']", 30); // stepKey: assertGiftMessageStatusDisableGiftMessageSettings
		$I->comment("Exiting Action Group [disableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [clickSaveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveSimpleProduct
		$I->comment("Exiting Action Group [clickSaveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Verify Url Key after changing");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/api-grouped-product" . msq("ApiGroupedProduct") . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert product design settings \"right bar is present at the  product page with 2 columns\"");
		$I->seeElement(".page-layout-2columns-right"); // stepKey: seeNewDesignChanges
		$I->comment("Assert Gift Option product settings");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->dontSeeElement(".action.action-gift"); // stepKey: dontSeeGiftOptionBtn
	}
}
