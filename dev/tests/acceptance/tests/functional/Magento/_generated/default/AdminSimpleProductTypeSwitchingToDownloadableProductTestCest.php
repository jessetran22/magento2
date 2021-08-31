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
 * @Title("MC-17956: Simple product type switching on editing to downloadable product")
 * @Description("Simple product type switching on editing to downloadable product<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminProductTypeSwitchingOnEditingTest/AdminSimpleProductTypeSwitchingToDownloadableProductTest.xml<br>")
 * @TestCaseId("MC-17956")
 * @group catalog
 */
class AdminSimpleProductTypeSwitchingToDownloadableProductTestCest
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
		$I->comment("Add downloadable domains");
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create product");
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Remove downloadable domains");
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete product");
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Product type switching"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSimpleProductTypeSwitchingToDownloadableProductTest(AcceptanceTester $I)
	{
		$I->comment("Change product type to Downloadable");
		$I->comment("Change product type to Downloadable");
		$I->comment("Entering Action Group [gotToDownloadableProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGotToDownloadableProductPage
		$I->comment("Exiting Action Group [gotToDownloadableProductPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForDownloadableProductPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectNoWeightForProduct
		$I->comment("Entering Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSectionAddDownloadableLinkInformation
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionAddDownloadableLinkInformationWaitForPageLoad
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkOptionIsDownloadableAddDownloadableLinkInformation
		$I->fillField("input[name='product[links_title]']", "Downloadable Links"); // stepKey: fillLinkTitleAddDownloadableLinkInformation
		$I->fillField("input[name='product[samples_title]']", "Downloadable Samples"); // stepKey: fillSampleTitleAddDownloadableLinkInformation
		$I->comment("Exiting Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkOptionPurchaseSeparately
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
		$I->comment("Entering Action Group [saveDownloadableProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveDownloadableProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveDownloadableProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveDownloadableProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveDownloadableProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveDownloadableProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveDownloadableProductForm
		$I->comment("Exiting Action Group [saveDownloadableProductForm] SaveProductFormActionGroup");
		$I->comment("Assert downloadable product on Admin product page grid");
		$I->comment("Assert configurable product in Admin product page grid");
		$I->comment("Entering Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage
		$I->comment("Exiting Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterProductGridBySku] FilterProductGridBySku2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku
		$I->comment("Exiting Action Group [filterProductGridBySku] FilterProductGridBySku2ActionGroup");
		$I->comment("Entering Action Group [seeDownloadableProductNameInGrid] AssertAdminProductGridCellActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeDownloadableProductNameInGrid
		$I->comment("Exiting Action Group [seeDownloadableProductNameInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeDownloadableProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->see("Downloadable Product", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Type']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeDownloadableProductTypeInGrid
		$I->comment("Exiting Action Group [seeDownloadableProductTypeInGrid] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [clearDownloadableProductFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearDownloadableProductFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearDownloadableProductFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearDownloadableProductFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearDownloadableProductFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearDownloadableProductFilters] AdminClearFiltersActionGroup");
		$I->comment("Assert downloadable product on storefront");
		$I->comment("Assert downloadable product on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openDownloadableProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontDownloadableProductPageLoad
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertDownloadableProductInStock
		$I->scrollTo("//div[contains(@class, 'field downloads required')]//span[text()='Downloadable Links']"); // stepKey: scrollToLinksInStorefront
		$I->seeElement("//label[contains(., 'Downloadable" . msq("downloadableLinkWithMaxDownloads") . "')]"); // stepKey: seeDownloadableLink
		$I->waitForPageLoad(30); // stepKey: seeDownloadableLinkWaitForPageLoad
	}
}
