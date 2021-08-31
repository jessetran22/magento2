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
 * @Title("MAGETWO-89910: Admin should be able to create a product with zero price")
 * @Description("Admin should be able to create a product with zero price<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateSimpleProductTest/AdminCreateSimpleProductZeroPriceTest.xml<br>")
 * @TestCaseId("MAGETWO-89910")
 * @group product
 */
class AdminCreateSimpleProductZeroPriceTestCest
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
	 * @Features({"Catalog"})
	 * @Stories({"Create a Simple Product via Admin"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateSimpleProductZeroPriceTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [goToCreateProduct] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: openProductNewPageGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [fillName] FillProductNameAndSkuInProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "Simple Product " . msq("SimpleProduct")); // stepKey: fillProductNameFillName
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillProductSkuFillName
		$I->comment("Exiting Action Group [fillName] FillProductNameAndSkuInProductFormActionGroup");
		$I->comment("Entering Action Group [fillPrice] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=price] input", 30); // stepKey: waitForPriceFieldFillPrice
		$I->fillField(".admin__field[data-index=price] input", "0"); // stepKey: fillPriceFieldFillPrice
		$I->pressKey(".admin__field[data-index=price] input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterButtonFillPrice
		$I->comment("Exiting Action Group [fillPrice] AdminFillProductPriceFieldAndPressEnterOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSave
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSave
		$I->comment("Exiting Action Group [clickSave] AdminProductFormSaveActionGroup");
		$I->comment("Entering Action Group [viewProduct] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/simple-product-" . msq("SimpleProduct") . ".html"); // stepKey: openProductPageViewProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedViewProduct
		$I->comment("Exiting Action Group [viewProduct] StorefrontOpenProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeZeroPrice] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->seeInTitle("Simple Product " . msq("SimpleProduct")); // stepKey: assertProductNameTitleSeeZeroPrice
		$I->see("Simple Product " . msq("SimpleProduct"), ".base"); // stepKey: assertProductNameSeeZeroPrice
		$I->see("$0.00", "div.price-box.price-final_price"); // stepKey: assertProductPriceSeeZeroPrice
		$I->comment("Exiting Action Group [seeZeroPrice] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
	}
}
