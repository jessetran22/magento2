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
 * @Title("MC-14508: Create downloadable product with custom options test")
 * @Description("Admin should be able to create downloadable product with custom options<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminCreateDownloadableProductWithCustomOptionsTest.xml<br>")
 * @TestCaseId("MC-14508")
 * @group Downloadable
 * @group mtf_migrated
 */
class AdminCreateDownloadableProductWithCustomOptionsTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete created downloadable product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("downloadableproduct" . msq("DownloadableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
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
	 * @Features({"Downloadable"})
	 * @Stories({"Create Downloadable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDownloadableProductWithCustomOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Create Downloadable product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [createProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']"); // stepKey: clickAddProductCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateProduct
		$I->comment("Exiting Action Group [createProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill downloadable product values");
		$I->comment("Entering Action Group [fillDownloadableProductForm] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=sku] input", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=price] input", "50.99"); // stepKey: fillProductPriceFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillDownloadableProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillDownloadableProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillDownloadableProductForm
		$I->comment("Exiting Action Group [fillDownloadableProductForm] FillMainProductFormNoWeightActionGroup");
		$I->comment("Add downloadable product to category");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Open custom option panel");
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: openCustomizableOptions
		$I->waitForPageLoad(30); // stepKey: waitForCustomOptionsOpen
		$I->comment("Create a first custom option with 2 values");
		$I->comment("Entering Action Group [createFirstCustomOption] AdminCreateCustomDropDownOptionsActionGroup");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionsCreateFirstCustomOption
		$I->waitForPageLoad(30); // stepKey: clickAddOptionsCreateFirstCustomOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddProductPageLoadCreateFirstCustomOption
		$I->comment("Fill in the option and select the type of drop down");
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionDropDown"); // stepKey: fillInOptionTitleCreateFirstCustomOption
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: clickOptionTypeParentCreateFirstCustomOption
		$I->waitForPageLoad(30); // stepKey: waitForDropdownOpenCreateFirstCustomOption
		$I->click("//*[@data-index='custom_options']//label[text()='Drop-down'][ancestor::*[contains(@class, '_active')]]"); // stepKey: clickOptionTypeCreateFirstCustomOption
		$I->comment("Add option based on the parameter");
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddFirstValueCreateFirstCustomOption
		$I->waitForPageLoad(30); // stepKey: clickAddFirstValueCreateFirstCustomOptionWaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionValueDropDown1"); // stepKey: fillInFirstOptionValueTitleCreateFirstCustomOption
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "0.01"); // stepKey: fillInFirstOptionValuePriceCreateFirstCustomOption
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddSecondValueCreateFirstCustomOption
		$I->waitForPageLoad(30); // stepKey: clickAddSecondValueCreateFirstCustomOptionWaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionValueDropDown2"); // stepKey: fillInSecondOptionValueTitleCreateFirstCustomOption
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "0.01"); // stepKey: fillInSecondOptionValuePriceCreateFirstCustomOption
		$I->comment("Exiting Action Group [createFirstCustomOption] AdminCreateCustomDropDownOptionsActionGroup");
		$I->comment("Create a second custom option with 2 values");
		$I->comment("Entering Action Group [createSecondCustomOption] AdminCreateCustomDropDownOptionsActionGroup");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionsCreateSecondCustomOption
		$I->waitForPageLoad(30); // stepKey: clickAddOptionsCreateSecondCustomOptionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddProductPageLoadCreateSecondCustomOption
		$I->comment("Fill in the option and select the type of drop down");
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "OptionDropDownWithLongTitles"); // stepKey: fillInOptionTitleCreateSecondCustomOption
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: clickOptionTypeParentCreateSecondCustomOption
		$I->waitForPageLoad(30); // stepKey: waitForDropdownOpenCreateSecondCustomOption
		$I->click("//*[@data-index='custom_options']//label[text()='Drop-down'][ancestor::*[contains(@class, '_active')]]"); // stepKey: clickOptionTypeCreateSecondCustomOption
		$I->comment("Add option based on the parameter");
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddFirstValueCreateSecondCustomOption
		$I->waitForPageLoad(30); // stepKey: clickAddFirstValueCreateSecondCustomOptionWaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionValueDropDown1"); // stepKey: fillInFirstOptionValueTitleCreateSecondCustomOption
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "0.01"); // stepKey: fillInFirstOptionValuePriceCreateSecondCustomOption
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddSecondValueCreateSecondCustomOption
		$I->waitForPageLoad(30); // stepKey: clickAddSecondValueCreateSecondCustomOptionWaitForPageLoad
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='title']//input", "OptionValueDropDown2"); // stepKey: fillInSecondOptionValueTitleCreateSecondCustomOption
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__control-table')]//tbody/tr[last()]//*[@data-index='price']//input", "0.01"); // stepKey: fillInSecondOptionValuePriceCreateSecondCustomOption
		$I->comment("Exiting Action Group [createSecondCustomOption] AdminCreateCustomDropDownOptionsActionGroup");
		$I->comment("Fill downloadable link information before the creation link");
		$I->comment("Entering Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSectionAddDownloadableLinkInformation
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionAddDownloadableLinkInformationWaitForPageLoad
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkOptionIsDownloadableAddDownloadableLinkInformation
		$I->fillField("input[name='product[links_title]']", "Downloadable Links"); // stepKey: fillLinkTitleAddDownloadableLinkInformation
		$I->fillField("input[name='product[samples_title]']", "Downloadable Samples"); // stepKey: fillSampleTitleAddDownloadableLinkInformation
		$I->comment("Exiting Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->comment("Links can be purchased separately");
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkOptionPurchaseSeparately
		$I->comment("Add downloadable link");
		$I->comment("Entering Action Group [addDownloadableProductLink] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddDownloadableProductLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][title]']", "Downloadable" . msq("downloadableLinkWithMaxDownloads")); // stepKey: fillDownloadableLinkTitleAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][price]']", "1.00"); // stepKey: fillDownloadableLinkPriceAddDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][type]']", "Upload File"); // stepKey: selectDownloadableLinkFileTypeAddDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][sample][type]']", "URL"); // stepKey: selectDownloadableLinkSampleTypeAddDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][is_shareable]']", "Yes"); // stepKey: selectDownloadableLinkShareableAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][number_of_downloads]']", "100"); // stepKey: fillDownloadableLinkMaxDownloadsAddDownloadableProductLink
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='0'] fieldset[data-index='container_file'] input[type='file']", "magento-logo.png"); // stepKey: fillDownloadableLinkUploadFileAddDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][sample][url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkSampleUrlAddDownloadableProductLink
		$I->comment("Exiting Action Group [addDownloadableProductLink] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->comment("Save product");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$runCronIndex = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Go to storefront category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->comment("Assert product in storefront category page");
		$I->comment("Entering Action Group [StorefrontCheckCategorySimpleProduct] StorefrontCheckProductPriceInCategoryActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]", 30); // stepKey: waitForProductStorefrontCheckCategorySimpleProduct
		$I->seeElement("//main//li//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]"); // stepKey: assertProductNameStorefrontCheckCategorySimpleProduct
		$I->see("50.99", "//main//li[.//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]]//span[@class='price']"); // stepKey: AssertProductPriceStorefrontCheckCategorySimpleProduct
		$I->moveMouseOver("//main//li[.//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductStorefrontCheckCategorySimpleProduct
		$I->seeElement("//main//li[.//a[contains(text(), 'DownloadableProduct" . msq("DownloadableProduct") . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartStorefrontCheckCategorySimpleProduct
		$I->comment("Exiting Action Group [StorefrontCheckCategorySimpleProduct] StorefrontCheckProductPriceInCategoryActionGroup");
		$I->comment("Assert product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPage] AssertProductNameAndSkuInStorefrontProductPageActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage("downloadableproduct" . msq("DownloadableProduct") . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPage
		$I->seeInTitle("DownloadableProduct" . msq("DownloadableProduct")); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPage
		$I->see("DownloadableProduct" . msq("DownloadableProduct"), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPage
		$I->see("downloadableproduct" . msq("DownloadableProduct"), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPage
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPage] AssertProductNameAndSkuInStorefrontProductPageActionGroup");
		$I->comment("Assert product custom options on product page");
		$I->scrollTo("//div[contains(@class, 'field downloads required')]//span[text()='Downloadable Links']"); // stepKey: scrollToLinksInStorefront
		$I->seeElement("//label[contains(., 'OptionDropDown')]"); // stepKey: seeFirstOptionName
		$I->seeElement("//label[contains(., 'OptionDropDownWithLongTitles')]"); // stepKey: seeSecondOptionName
		$I->comment("Assert downloadable links data");
		$I->scrollTo("//div[contains(@class, 'field downloads required')]//span[text()='Downloadable Links']"); // stepKey: scrollToLinks
		$I->seeElement("//label[contains(., 'Downloadable" . msq("downloadableLinkWithMaxDownloads") . "')]"); // stepKey: seeDownloadableLink
		$I->waitForPageLoad(30); // stepKey: seeDownloadableLinkWaitForPageLoad
	}
}
