<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-3245: Admin should be able to set/edit other product information when creating/editing a virtual product")
 * @Description("Admin should be able to set/edit other product information when creating/editing a virtual product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateAndEditVirtualProductSettingsTest.xml<br>")
 * @TestCaseId("MC-3245")
 * @group Catalog
 * @group WYSIWYGDisabled
 */
class AdminCreateAndEditVirtualProductSettingsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create related products");
		$I->createEntity("createFirstRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstRelatedProduct
		$I->createEntity("createSecondRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondRelatedProduct
		$I->createEntity("createThirdRelatedProduct", "hook", "SimpleProduct2", [], []); // stepKey: createThirdRelatedProduct
		$I->comment("Create website");
		$I->createEntity("createWebsite", "hook", "secondCustomWebsite", [], []); // stepKey: createWebsite
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
		$I->comment("Delete created virtual product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("virtualProduct" . msq("defaultVirtualProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
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
		$I->comment("Delete website");
		$I->comment("Entering Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", $I->retrieveEntityField('createWebsite', 'website[name]', 'hook')); // stepKey: fillSearchWebsiteFieldDeleteWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteWebsiteWaitForPageLoad
		$I->see($I->retrieveEntityField('createWebsite', 'website[name]', 'hook'), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Delete related products");
		$I->deleteEntity("createFirstRelatedProduct", "hook"); // stepKey: deleteFirstRelatedProduct
		$I->deleteEntity("createSecondRelatedProduct", "hook"); // stepKey: deleteSecondRelatedProduct
		$I->deleteEntity("createThirdRelatedProduct", "hook"); // stepKey: deleteThirdRelatedProduct
		$I->comment("Log out");
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
	 * @Stories({"Create/Edit virtual product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateAndEditVirtualProductSettingsTest(AcceptanceTester $I)
	{
		$I->comment("remove me");
		$I->comment("Create new virtual product");
		$I->comment("Entering Action Group [createVirtualProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateVirtualProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateVirtualProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-virtual']"); // stepKey: clickAddProductCreateVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateVirtualProduct
		$I->comment("Exiting Action Group [createVirtualProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill all main fields");
		$I->comment("Entering Action Group [fillMainProductForm] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillProductNameFillMainProductForm
		$I->fillField(".admin__field[data-index=sku] input", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillProductSkuFillMainProductForm
		$I->fillField(".admin__field[data-index=price] input", "12.34"); // stepKey: fillProductPriceFillMainProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillMainProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillMainProductForm
		$I->comment("Exiting Action Group [fillMainProductForm] FillMainProductFormNoWeightActionGroup");
		$I->comment("Set Content to the product");
		$I->scrollTo("div[data-index='content']", 0, -100); // stepKey: scrollToContent
		$I->waitForPageLoad(30); // stepKey: scrollToContentWaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: openContentDropDown
		$I->waitForPageLoad(30); // stepKey: openContentDropDownWaitForPageLoad
		$I->fillField("#product_form_description", "API Product Description" . msq("ApiProductDescription")); // stepKey: fillLongDescription
		$I->fillField("#product_form_short_description", "API Product Short Description" . msq("ApiProductShortDescription")); // stepKey: fillShortDescription
		$I->comment("Add two related products");
		$I->comment("Entering Action Group [addFirstRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddFirstRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddFirstRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddFirstRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddFirstRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddFirstRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createFirstRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddFirstRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddFirstRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddFirstRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddFirstRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddFirstRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddFirstRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddFirstRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addFirstRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addSecondRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddSecondRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddSecondRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddSecondRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddSecondRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddSecondRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSecondRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddSecondRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddSecondRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddSecondRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddSecondRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddSecondRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddSecondRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddSecondRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addSecondRelatedProduct] AddRelatedProductBySkuActionGroup");
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
		$I->selectOption("select[name='product[page_layout]']", "1 column"); // stepKey: setLayoutSetProductDesignSettings
		$I->selectOption("select[name='product[options_container]']", "Product Info Column"); // stepKey: setDisplayProductOptionsSetProductDesignSettings
		$I->comment("Exiting Action Group [setProductDesignSettings] AdminSetProductDesignSettingsActionGroup");
		$I->comment("Set Gift Options settings for the product");
		$I->comment("Entering Action Group [enableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->click("div[data-index='gift-options']"); // stepKey: clickToExpandGiftOptionsTabEnableGiftMessageSettings
		$I->waitForPageLoad(30); // stepKey: waitForGiftOptionsOpenEnableGiftMessageSettings
		$I->uncheckOption("[name='product[use_config_gift_message_available]']"); // stepKey: uncheckConfigSettingsMessageEnableGiftMessageSettings
		$I->click("input[name='product[gift_message_available]']+label"); // stepKey: clickToGiftMessageSwitcherEnableGiftMessageSettings
		$I->waitForElementVisible("input[name='product[gift_message_available]'][value='1']", 30); // stepKey: assertGiftMessageStatusEnableGiftMessageSettings
		$I->comment("Exiting Action Group [enableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->comment("Save product form");
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
		$I->comment("Open product page");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/virtualproduct" . msq("defaultVirtualProduct") . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert two related products at the storefront");
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createFirstRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeFirstRelatedProductInStorefront
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createSecondRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeSecondRelatedProductInStorefront
		$I->comment("Assert product content");
		$I->see("API Product Description" . msq("ApiProductDescription"), "#description .value"); // stepKey: seeLongDescriptionStorefront
		$I->see("API Product Short Description" . msq("ApiProductShortDescription"), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: seeShortDescriptionStorefront
		$I->comment("Assert product design settings \"page layout 1 column\"");
		$I->seeElement(".page-layout-1column"); // stepKey: seeDesignChanges
		$I->comment("Assert Gift Option product settings is not present");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added virtualProduct" . msq("defaultVirtualProduct") . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
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
		$I->dontSeeElement(".action.action-gift"); // stepKey: dontSeeGiftOption
		$I->comment("Open created product");
		$I->comment("Entering Action Group [searchForVirtualProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForVirtualProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForVirtualProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForVirtualProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForVirtualProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForVirtualProductWaitForPageLoad
		$I->fillField("input[name=sku]", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: fillSkuFieldOnFiltersSectionSearchForVirtualProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForVirtualProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForVirtualProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='virtualProduct" . msq("defaultVirtualProduct") . "']]"); // stepKey: clickOnProductRowOpenEditProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct
		$I->seeInField(".admin__field[data-index=sku] input", "virtualProduct" . msq("defaultVirtualProduct")); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct
		$I->comment("Exiting Action Group [openEditProduct] OpenEditProductOnBackendActionGroup");
		$I->comment("Edit Content to the product");
		$I->scrollTo("div[data-index='content']", 0, -100); // stepKey: scrollToContentTab
		$I->waitForPageLoad(30); // stepKey: scrollToContentTabWaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: openContentTab
		$I->waitForPageLoad(30); // stepKey: openContentTabWaitForPageLoad
		$I->fillField("#product_form_description", "EDIT ~ API Product Description" . msq("ApiProductDescription") . " ~ EDIT"); // stepKey: editLongDescription
		$I->fillField("#product_form_short_description", "EDIT ~ API Product Short Description" . msq("ApiProductShortDescription") . " ~ EDIT"); // stepKey: editShortDescription
		$I->comment("Edit product Search Engine Optimization settings");
		$I->comment("Entering Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettings
		$I->waitForPageLoad(30); // stepKey: clickSearchEngineOptimizationTabEditProductSEOSettingsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenEditProductSEOSettings
		$I->fillField("input[name='product[url_key]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setUrlKeyInputEditProductSEOSettings
		$I->fillField("input[name='product[meta_title]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setMetaTitleInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_keyword]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setMetaKeywordsInputEditProductSEOSettings
		$I->fillField("textarea[name='product[meta_description]']", "Simple Product " . msq("SimpleProduct")); // stepKey: setMetaDescriptionInputEditProductSEOSettings
		$I->comment("Exiting Action Group [editProductSEOSettings] AdminChangeProductSEOSettingsActionGroup");
		$I->comment("Edit related products");
		$I->comment("Entering Action Group [addThirdRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: scrollToAddThirdRelatedProductWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddThirdRelatedProduct
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddThirdRelatedProductWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddThirdRelatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddThirdRelatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createThirdRelatedProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddThirdRelatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddThirdRelatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddThirdRelatedProduct
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: selectProductAddThirdRelatedProductWaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddThirdRelatedProductWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddThirdRelatedProduct
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddThirdRelatedProductWaitForPageLoad
		$I->comment("Exiting Action Group [addThirdRelatedProduct] AddRelatedProductBySkuActionGroup");
		$I->comment("Assert product in assigned to websites");
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
		$I->comment("Edit Gift Option product settings");
		$I->comment("Entering Action Group [disableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->click("div[data-index='gift-options']"); // stepKey: clickToExpandGiftOptionsTabDisableGiftMessageSettings
		$I->waitForPageLoad(30); // stepKey: waitForGiftOptionsOpenDisableGiftMessageSettings
		$I->uncheckOption("[name='product[use_config_gift_message_available]']"); // stepKey: uncheckConfigSettingsMessageDisableGiftMessageSettings
		$I->click("input[name='product[gift_message_available]']+label"); // stepKey: clickToGiftMessageSwitcherDisableGiftMessageSettings
		$I->waitForElementVisible("input[name='product[gift_message_available]'][value='0']", 30); // stepKey: assertGiftMessageStatusDisableGiftMessageSettings
		$I->comment("Exiting Action Group [disableGiftMessageSettings] AdminSwitchProductGiftMessageStatusActionGroup");
		$I->comment("Save product form");
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
		$I->comment("Verify Url Key after changing");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/simple-product-" . msq("SimpleProduct") . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Assert three related products at the storefront");
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createThirdRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeFirstRelatedProduct
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createSecondRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeSecondRelatedProduct
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('createThirdRelatedProduct', 'name', 'test') . "')]"); // stepKey: seeThirdRelatedProduct
		$I->comment("Assert product content");
		$I->see("EDIT ~ API Product Description" . msq("ApiProductDescription") . " ~ EDIT", "#description .value"); // stepKey: seeEditedLongDescriptionStorefront
		$I->see("EDIT ~ API Product Short Description" . msq("ApiProductShortDescription") . " ~ EDIT", "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: seeEditedShortDescriptionStorefront
		$I->comment("Assert product design settings \"right bar is present at product page with 2 columns\"");
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
		$I->comment("remove me");
	}
}
