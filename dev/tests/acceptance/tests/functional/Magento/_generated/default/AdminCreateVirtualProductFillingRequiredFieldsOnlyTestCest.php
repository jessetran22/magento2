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
 * @Title("MC-6031: Create virtual product filling required fields only")
 * @Description("Test log in to Create virtual product and Create virtual product filling required fields only<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateVirtualProductFillingRequiredFieldsOnlyTest.xml<br>")
 * @TestCaseId("MC-6031")
 * @group catalog
 * @group mtf_migrated
 */
class AdminCreateVirtualProductFillingRequiredFieldsOnlyTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Stories({"Create virtual product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateVirtualProductFillingRequiredFieldsOnlyTest(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickVirtualProduct] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/virtual/"); // stepKey: openProductNewPageClickVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickVirtualProduct
		$I->comment("Exiting Action Group [clickVirtualProduct] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Create virtual product with required fields only");
		$I->comment("Entering Action Group [fillProductName] FillProductNameAndSkuInProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "virtualProduct" . msq("virtualProductWithRequiredFields")); // stepKey: fillProductNameFillProductName
		$I->fillField(".admin__field[data-index=sku] input", "virtualsku" . msq("virtualProductWithRequiredFields")); // stepKey: fillProductSkuFillProductName
		$I->comment("Exiting Action Group [fillProductName] FillProductNameAndSkuInProductFormActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [fillProductPrice] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=price] input", 30); // stepKey: waitForPriceFieldFillProductPrice
		$I->fillField(".admin__field[data-index=price] input", "10"); // stepKey: fillPriceFieldFillProductPrice
		$I->pressKey(".admin__field[data-index=price] input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterButtonFillProductPrice
		$I->comment("Exiting Action Group [fillProductPrice] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify we see success message");
		$I->comment("Entering Action Group [seeAssertVirtualProductSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeAssertVirtualProductSuccessMessage
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: verifyMessageSeeAssertVirtualProductSuccessMessage
		$I->comment("Exiting Action Group [seeAssertVirtualProductSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Verify we see created virtual product(from the above step) on the product grid page");
		$I->comment("Entering Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage1
		$I->comment("Exiting Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickSearch2] FilterProductGridBySkuAndNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialClickSearch2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialClickSearch2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersClickSearch2
		$I->fillField("input.admin__control-text[name='sku']", "virtualsku" . msq("virtualProductWithRequiredFields")); // stepKey: fillProductSkuFilterClickSearch2
		$I->fillField("input.admin__control-text[name='name']", "virtualProduct" . msq("virtualProductWithRequiredFields")); // stepKey: fillProductNameFilterClickSearch2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersClickSearch2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersClickSearch2WaitForPageLoad
		$I->comment("Exiting Action Group [clickSearch2] FilterProductGridBySkuAndNameActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [seeVirtualProductName] AssertAdminProductGridCellActionGroup");
		$I->see("virtualProduct" . msq("virtualProductWithRequiredFields"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeVirtualProductName
		$I->comment("Exiting Action Group [seeVirtualProductName] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeVirtualProductSku] AssertAdminProductGridCellActionGroup");
		$I->see("virtualsku" . msq("virtualProductWithRequiredFields"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeVirtualProductSku
		$I->comment("Exiting Action Group [seeVirtualProductSku] AssertAdminProductGridCellActionGroup");
	}
}
