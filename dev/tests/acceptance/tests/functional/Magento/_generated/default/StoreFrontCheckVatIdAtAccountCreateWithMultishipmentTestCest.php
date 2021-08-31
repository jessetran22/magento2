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
 * @Title("MC-40397: Checking vat id field at account create page  with 'Check Out with Multiple Addresses'")
 * @Description("'VAT Number' field should be available at create account page  if 'Show VAT Number on Storefront' is Yes<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StoreFrontCheckVatIdAtAccountCreateWithMultishipmentTest.xml<br>")
 * @TestCaseId("MC-40397")
 * @group Multishipment
 */
class StoreFrontCheckVatIdAtAccountCreateWithMultishipmentTestCest
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
		$showVatNumberOnStorefrontYes = $I->magentoCLI("config:set customer/create_account/vat_frontend_visibility 1", 60); // stepKey: showVatNumberOnStorefrontYes
		$I->comment($showVatNumberOnStorefrontYes);
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$showVatNumberOnStorefrontNo = $I->magentoCLI("config:set customer/create_account/vat_frontend_visibility 0", 60); // stepKey: showVatNumberOnStorefrontNo
		$I->comment($showVatNumberOnStorefrontNo);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product", "hook"); // stepKey: deleteproduct
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
	 * @Features({"Multishipping"})
	 * @Stories({"Checking vat id field at account create page  with 'Check Out with Multiple Addresses'"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontCheckVatIdAtAccountCreateWithMultishipmentTest(AcceptanceTester $I)
	{
		$I->comment("Add product to the cart");
		$I->amOnPage($I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->comment("Entering Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Check Out with Multiple Addresses");
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
		$I->waitForElementVisible(".action.multicheckout", 30); // stepKey: waitMultipleAddressShippingButton
		$I->click(".action.multicheckout"); // stepKey: clickToMultipleAddressShippingButton
		$I->comment("Create an account");
		$I->waitForElementVisible("//div[contains(@class,'actions-toolbar')]//a[contains(.,'Create an Account')]", 30); // stepKey: waitCreateAnAccountButton
		$I->waitForPageLoad(30); // stepKey: waitCreateAnAccountButtonWaitForPageLoad
		$I->click("//div[contains(@class,'actions-toolbar')]//a[contains(.,'Create an Account')]"); // stepKey: clickOnCreateAnAccountButton
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAnAccountButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountPageToLoad
		$I->comment("Check the VAT Number field");
		$I->seeElement("#vat_id"); // stepKey: assertVatIdField
	}
}
