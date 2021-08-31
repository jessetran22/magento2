<?php
namespace Magento\AcceptanceTest\_RemoteStorageAwsS3EnabledSuite\Backend;

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
 * @Title("MC-38036: Create, view and check out downloadable product with remote filesystem configured.")
 * @Description("Admin should be able to create downloadable product with remote filesystem enabled<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AwsS3AdminCreateDownloadableProductWithLinkTest.xml<br>")
 * @TestCaseId("MC-38036")
 * @group Downloadable
 * @group remote_storage_aws_s3
 */
class AwsS3AdminCreateDownloadableProductWithLinkTestCest
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
        $this->helperContainer->create("\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("BIC workaround");
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
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
		$I->comment("BIC workaround");
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"AwsS3"})
	 * @Stories({"Support remote file storage by downloadable products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AwsS3AdminCreateDownloadableProductWithLinkTest(AcceptanceTester $I)
	{
		$I->comment("Create downloadable product");
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
		$I->comment("Add downloadable links");
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSection
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionWaitForPageLoad
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkIsDownloadable
		$I->fillField("input[name='product[links_title]']", "Downloadable Links"); // stepKey: fillDownloadableLinkTitle
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkLinksPurchasedSeparately
		$I->fillField("input[name='product[samples_title]']", "Downloadable Samples"); // stepKey: fillDownloadableSampleTitle
		$I->comment("Entering Action Group [addDownloadableLinkWithMaxDownloads] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddDownloadableLinkWithMaxDownloads
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][title]']", "Downloadable" . msq("downloadableLinkWithMaxDownloads")); // stepKey: fillDownloadableLinkTitleAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][price]']", "1.00"); // stepKey: fillDownloadableLinkPriceAddDownloadableLinkWithMaxDownloads
		$I->selectOption("select[name='downloadable[link][0][type]']", "Upload File"); // stepKey: selectDownloadableLinkFileTypeAddDownloadableLinkWithMaxDownloads
		$I->selectOption("select[name='downloadable[link][0][sample][type]']", "URL"); // stepKey: selectDownloadableLinkSampleTypeAddDownloadableLinkWithMaxDownloads
		$I->selectOption("select[name='downloadable[link][0][is_shareable]']", "Yes"); // stepKey: selectDownloadableLinkShareableAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][number_of_downloads]']", "100"); // stepKey: fillDownloadableLinkMaxDownloadsAddDownloadableLinkWithMaxDownloads
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='0'] fieldset[data-index='container_file'] input[type='file']", "magento-logo.png"); // stepKey: fillDownloadableLinkUploadFileAddDownloadableLinkWithMaxDownloads
		$I->fillField("input[name='downloadable[link][0][sample][url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkSampleUrlAddDownloadableLinkWithMaxDownloads
		$I->comment("Exiting Action Group [addDownloadableLinkWithMaxDownloads] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->comment("Entering Action Group [addDownloadableLink] AddDownloadableProductLinkActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddDownloadableLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableLink
		$I->fillField("input[name='downloadable[link][1][title]']", "DownloadableLink" . msq("downloadableLink")); // stepKey: fillDownloadableLinkTitleAddDownloadableLink
		$I->fillField("input[name='downloadable[link][1][price]']", "2.00"); // stepKey: fillDownloadableLinkPriceAddDownloadableLink
		$I->selectOption("select[name='downloadable[link][1][type]']", "URL"); // stepKey: selectDownloadableLinkFileTypeAddDownloadableLink
		$I->selectOption("select[name='downloadable[link][1][sample][type]']", "Upload File"); // stepKey: selectDownloadableLinkSampleTypeAddDownloadableLink
		$I->selectOption("select[name='downloadable[link][1][is_shareable]']", "No"); // stepKey: selectDownloadableLinkShareableAddDownloadableLink
		$I->checkOption("input[name='downloadable[link][1][is_unlimited]']"); // stepKey: checkDownloadableLinkUnlimitedAddDownloadableLink
		$I->fillField("input[name='downloadable[link][1][link_url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkFileUrlAddDownloadableLink
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='1'] fieldset[data-index='container_sample'] input[type='file']", "magento-logo.png"); // stepKey: attachDownloadableLinkUploadSampleAddDownloadableLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterFillingOutFormAddDownloadableLink
		$I->comment("Exiting Action Group [addDownloadableLink] AddDownloadableProductLinkActionGroup");
		$I->comment("Add downloadable sample");
		$I->comment("Entering Action Group [addDownloadableProductSample] AddDownloadableSampleFileActionGroup");
		$I->click("div[data-index='container_samples'] button[data-action='add_new_row']"); // stepKey: clickSampleAddLinkButtonAddDownloadableProductSample
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddDownloadableProductSample
		$I->fillField("input[name='downloadable[sample][0][title]']", "SampleFile" . msq("downloadableSampleFile")); // stepKey: fillDownloadableSampleTitleAddDownloadableProductSample
		$I->selectOption("select[name='downloadable[sample][0][type]']", "Upload File"); // stepKey: selectDownloadableSampleFileTypeAddDownloadableProductSample
		$I->attachFile("div[data-index='container_samples'] tr[data-repeat-index='0'] input[type='file']", "magento-logo.png"); // stepKey: selectDownloadableSampleUploadAddDownloadableProductSample
		$I->waitForAjaxLoad(30); // stepKey: waitForSampleFileUploadAddDownloadableProductSample
		$I->comment("Exiting Action Group [addDownloadableProductSample] AddDownloadableSampleFileActionGroup");
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
		$runIndexCronJobs = $I->magentoCron("index", 90); // stepKey: runIndexCronJobs
		$I->comment($runIndexCronJobs);
		$I->comment("Login to frontend");
		$I->comment("Entering Action Group [signIn] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageSignIn
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedSignIn
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsSignIn
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailSignIn
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordSignIn
		$I->click("#send2"); // stepKey: clickSignInAccountButtonSignIn
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonSignInWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInSignIn
		$I->comment("Exiting Action Group [signIn] LoginToStorefrontActionGroup");
		$I->comment("Assert product in storefront category page");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
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
		$I->comment("Assert product price in storefront product page");
		$I->see("50.99", "div.price-box.price-final_price"); // stepKey: assertProductPrice
		$I->comment("Assert link sample urls are accessible");
		$I->comment("Click on the link sample");
		$I->comment("Entering Action Group [seeDownloadableLinkSampleWithMaxDownloads] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeDownloadableLinkSampleWithMaxDownloads
		$I->scrollTo("//label[contains(., 'Downloadable" . msq("downloadableLinkWithMaxDownloads") . "')]/a[contains(@class, 'sample link')]"); // stepKey: scrollToElementSeeDownloadableLinkSampleWithMaxDownloads
		$I->seeElement("//label[contains(., 'Downloadable" . msq("downloadableLinkWithMaxDownloads") . "')]/a[contains(@class, 'sample link')]"); // stepKey: assertElementSeeDownloadableLinkSampleWithMaxDownloads
		$I->comment("Exiting Action Group [seeDownloadableLinkSampleWithMaxDownloads] AssertStorefrontSeeElementActionGroup");
		$I->click("//label[contains(., 'Downloadable" . msq("downloadableLinkWithMaxDownloads") . "')]/a[contains(@class, 'sample link')]"); // stepKey: clickDownloadableLinkSampleWithMaxDownloads
		$I->waitForPageLoad(30); // stepKey: waitForLinkSampleWithMaxDownloadsPage
		$I->comment("Grab Link Sample id");
		$I->switchToNextTab(); // stepKey: switchToLinkSampleWithMaxDownloadsTab
		$grabDownloadableLinkWithMaxDownloadsId = $I->grabFromCurrentUrl("~/link_id/(\d+)/~"); // stepKey: grabDownloadableLinkWithMaxDownloadsId
		$I->comment("Check is svg");
		$I->seeElement("//*[@id='Logo']"); // stepKey: assertDownloadableLinkWithMaxDownloadsIsSvg
		$I->closeTab(); // stepKey: closeLinkSampleWithMaxDownloadsTab
		$I->comment("Click on the link sample");
		$I->comment("Entering Action Group [seeDownloadableLinkSample] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeDownloadableLinkSample
		$I->scrollTo("//label[contains(., 'DownloadableLink" . msq("downloadableLink") . "')]/a[contains(@class, 'sample link')]"); // stepKey: scrollToElementSeeDownloadableLinkSample
		$I->seeElement("//label[contains(., 'DownloadableLink" . msq("downloadableLink") . "')]/a[contains(@class, 'sample link')]"); // stepKey: assertElementSeeDownloadableLinkSample
		$I->comment("Exiting Action Group [seeDownloadableLinkSample] AssertStorefrontSeeElementActionGroup");
		$I->click("//label[contains(., 'DownloadableLink" . msq("downloadableLink") . "')]/a[contains(@class, 'sample link')]"); // stepKey: clickDownloadableLinkSample
		$I->waitForPageLoad(30); // stepKey: waitForLinkSamplePage
		$I->comment("Grab Link Sample id");
		$I->switchToNextTab(); // stepKey: switchToLinkSampleTab
		$grabDownloadableLinkSampleId = $I->grabFromCurrentUrl("~/link_id/(\d+)/~"); // stepKey: grabDownloadableLinkSampleId
		$I->comment("Check is image");
		$I->seeElement("//img[contains(@style, '-webkit-user-select')]"); // stepKey: assertDownloadableLinkSampleIsImage
		$I->closeTab(); // stepKey: closeLinkSampleTab
		$I->comment("Assert sample file is accessible");
		$I->comment("Entering Action Group [seeDownloadableSample] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeDownloadableSample
		$I->scrollTo("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('SampleFile" . msq("downloadableSampleFile") . "'))]"); // stepKey: scrollToElementSeeDownloadableSample
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeDownloadableSampleWaitForPageLoad
		$I->seeElement("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('SampleFile" . msq("downloadableSampleFile") . "'))]"); // stepKey: assertElementSeeDownloadableSample
		$I->waitForPageLoad(30); // stepKey: assertElementSeeDownloadableSampleWaitForPageLoad
		$I->comment("Exiting Action Group [seeDownloadableSample] AssertStorefrontSeeElementActionGroup");
		$I->click("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('SampleFile" . msq("downloadableSampleFile") . "'))]"); // stepKey: clickDownloadableSample
		$I->waitForPageLoad(30); // stepKey: clickDownloadableSampleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSamplePage
		$I->comment("Grab Sample id");
		$I->switchToNextTab(); // stepKey: switchToSampleTab
		$grabDownloadableSampleId = $I->grabFromCurrentUrl("~/sample_id/(\d+)/~"); // stepKey: grabDownloadableSampleId
		$I->comment("Check is image");
		$I->seeElement("//img[contains(@style, '-webkit-user-select')]"); // stepKey: assertDownloadableSampleIsImage
		$I->closeTab(); // stepKey: closeSampleTab
		$I->comment("Select product link in storefront product page");
		$I->scrollTo("//div[contains(@class, 'field downloads required')]//span[text()='Downloadable Links']"); // stepKey: scrollToLinks
		$I->click("//*[@id='downloadable-links-list']/*[contains(.,'DownloadableLink" . msq("downloadableLink") . "')]//input"); // stepKey: selectProductLink
		$I->waitForPageLoad(30); // stepKey: selectProductLinkWaitForPageLoad
		$I->comment("Add product with selected link to the cart");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added DownloadableProduct" . msq("DownloadableProduct") . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Assert product price in cart");
		$I->comment("Entering Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage
		$I->comment("Exiting Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->see("$52.99", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='DownloadableProduct" . msq("DownloadableProduct") . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceInCart
		$I->comment("Perform checkout");
		$I->comment("Entering Action Group [navigateToCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageNavigateToCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedNavigateToCheckoutPage
		$I->comment("Exiting Action Group [navigateToCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyOrder
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyOrder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyOrder
		$I->comment("Exiting Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlacePurchaseOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlacePurchaseOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlacePurchaseOrder
		$I->comment("Exiting Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Open Create invoice");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("Entering Action Group [goToOrderInAdmin] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageGoToOrderInAdmin
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersGoToOrderInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToOrderInAdmin
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersGoToOrderInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersGoToOrderInAdmin
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterGoToOrderInAdmin
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersGoToOrderInAdminWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageGoToOrderInAdmin
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageGoToOrderInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersGoToOrderInAdmin
		$I->comment("Exiting Action Group [goToOrderInAdmin] OpenOrderByIdActionGroup");
		$I->comment("BIC workaround");
		$I->comment("Entering Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartInvoice
		$I->comment("Exiting Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessSubmitInvoice
		$grabOrderIdSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceSubmitInvoice
		$I->comment("Exiting Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Check downloadable product link on frontend");
		$I->comment("Entering Action Group [seeStorefrontMyAccountDownloadableProductsLink] StorefrontAssertDownloadableProductIsPresentInCustomerAccount");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageSeeStorefrontMyAccountDownloadableProductsLink
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Downloadable Products']"); // stepKey: clickDownloadableProductsSeeStorefrontMyAccountDownloadableProductsLink
		$I->waitForPageLoad(60); // stepKey: clickDownloadableProductsSeeStorefrontMyAccountDownloadableProductsLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDownloadableProductsPageLoadSeeStorefrontMyAccountDownloadableProductsLink
		$I->seeElement("//table[@id='my-downloadable-products-table']//strong[contains(@class, 'product-name') and normalize-space(.)='DownloadableProduct" . msq("DownloadableProduct") . "']"); // stepKey: seeStorefontDownloadableProductsProductNameSeeStorefrontMyAccountDownloadableProductsLink
		$I->comment("Exiting Action Group [seeStorefrontMyAccountDownloadableProductsLink] StorefrontAssertDownloadableProductIsPresentInCustomerAccount");
		$I->click("//table[@id='my-downloadable-products-table']//a[contains(@class, 'download')]"); // stepKey: clickDownloadLink
		$I->waitForPageLoad(30); // stepKey: waitForDownloadedLinkPage
		$I->comment("Grab downloadable URL");
		$I->switchToNextTab(); // stepKey: switchToDownloadedLinkTab
		$grabDownloadLinkUrl = $I->grabFromCurrentUrl("~/link/id/(.+)/~"); // stepKey: grabDownloadLinkUrl
		$I->comment("Check is svg");
		$I->seeElement("//*[@id='Logo']"); // stepKey: assertDownloadedLinkIsSvg
		$I->closeTab(); // stepKey: closeDownloadedLinkTab
	}
}
